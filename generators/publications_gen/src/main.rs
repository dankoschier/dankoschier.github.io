use std::collections::HashMap;

use build_html::*;
use build_html::{Html, HtmlContainer};
use serde::{Deserialize, Serialize};

#[derive(Debug, Serialize, Deserialize)]
struct Affiliation {
    id: String,
    name: String,
}

#[derive(Debug, Serialize, Deserialize)]
struct Author {
    id: String,
    last_name: String,
    first_name: String,
    affiliation_id: Option<String>,
    url: Option<String>,
}

#[derive(Debug, Serialize, Deserialize)]
struct Journal {
    id: String,
    name: String,
    priority: i32,
}

#[derive(Debug, Serialize, Deserialize)]
struct Publication {
    title: String,
    authors: Vec<String>,
    year: i32,
    journal_id: String,
    bibtex_key: String,
    youtube: Option<String>,
    annotation: Option<String>,
    bibtex: String,
    file_url: Option<String>,
}

#[derive(Debug, Serialize, Deserialize)]
struct PublicationsDatabase {
    affiliations: Vec<Affiliation>,
    authors: Vec<Author>,
    journals: Vec<Journal>,
    publications: Vec<Publication>,
}

fn main() {
    let template_str = std::fs::read_to_string("../../index.html.template").unwrap();
    let publications_html_str = generate_publications_html();
    let html_str = template_str.replace("{publications_html}", &publications_html_str);
    std::fs::write("../../index.html", html_str).unwrap();
}

fn generate_publications_html() -> String {
    let path = "publications.json";
    let publications_json = std::fs::read_to_string(path).unwrap();
    let db: PublicationsDatabase = serde_json::from_str(&publications_json).unwrap();

    let authors = db
        .authors
        .iter()
        .map(|author| (&author.id, author))
        .collect::<HashMap<_, _>>();

    let journals = db
        .journals
        .iter()
        .map(|journal| (&journal.id, journal))
        .collect::<HashMap<_, _>>();

    let journals_clone = journals.clone();
    let mut publications = db.publications;
    publications.sort_by_key(|publication| {
        (
            publication.year,
            journals_clone
                .get(&publication.journal_id)
                .unwrap()
                .priority,
        )
    });
    publications.reverse();

    let mut html_str = String::default();
    for publication in publications {
        let _bibkey_dummy = Container::default().with_attributes([
            ("class", "bibkey-dummy"),
            ("id", publication.bibtex_key.as_ref()),
            ("yt_code", publication.youtube.as_deref().unwrap_or("none")),
            ("bibtex", publication.bibtex.as_ref()),
        ]);

        let mut authors_block = Container::default();
        for (author_index, author) in publication
            .authors
            .iter()
            .map(|author_id| authors.get(author_id).unwrap())
            .enumerate()
        {
            let author_name = format!("{} {}", &author.first_name, &author.last_name);
            if let Some(url) = author.url.as_deref() {
                authors_block.add_link_attr(url, author_name, [("class", "author-link")])
            } else {
                authors_block.add_raw(author_name)
            };
            if author_index < publication.authors.len() - 1 {
                authors_block.add_raw(", ");
            }
        }

        let n_fields = match publication.youtube {
            Some(_) => 4,
            None => 6,
        };
        let icon_size = 32;
        let file = publication
            .file_url
            .unwrap_or(format!("resources/papers/{}.pdf", &publication.bibtex_key));

        let mut inner_row = Container::default()
            .with_attributes([("class", "row material-block")])
            .with_container(
                Container::default()
                    .with_attributes([(
                        "class",
                        format!("col-xs-{} material-link", n_fields).as_ref(),
                    )])
                    .with_link_attr(
                        file,
                        Container::default()
                            .with_image_attr(
                                "png/document_icon.svg",
                                "pdf",
                                [
                                    (
                                        "id",
                                        format!("pdf_icon_{}", &publication.bibtex_key).as_ref(),
                                    ),
                                    ("width", icon_size.to_string().as_ref()),
                                    ("height", icon_size.to_string().as_ref()),
                                ],
                            )
                            .to_html_string(),
                        [(
                            "id",
                            format!("pdf_link_{}", &publication.bibtex_key).as_ref(),
                        )],
                    ),
            );

        if publication.youtube.is_some() {
            inner_row.add_container(
                Container::default()
                    .with_attributes([("class", "col-xs-4 material-link")])
                    .with_image_attr(
                        "png/video_icon.svg",
                        "video",
                        [
                            ("class", "video-icon"),
                            (
                                "id",
                                format!("video_icon_{}", &publication.bibtex_key).as_ref(),
                            ),
                            ("width", icon_size.to_string().as_ref()),
                            ("height", icon_size.to_string().as_ref()),
                        ],
                    ),
            )
        }

        inner_row.add_container(
            Container::default()
                .with_attributes([(
                    "class",
                    format!("col-xs-{} material-link", n_fields).as_ref(),
                )])
                .with_image_attr(
                    "png/cite_icon.svg",
                    "cite",
                    [
                        ("class", "cite-icon"),
                        (
                            "id",
                            format!("cite_icon_{}", &publication.bibtex_key).as_ref(),
                        ),
                        ("width", icon_size.to_string().as_ref()),
                        ("height", icon_size.to_string().as_ref()),
                    ],
                ),
        );

        let content = Container::default()
            .with_attributes([("class", "col-md-8 pub_description col-sm-height col-middle")])
            .with_header(3, &publication.title)
            .with_header(4, authors_block.to_html_string())
            .with_header(
                4,
                format!(
                    "{} ({})",
                    &journals.get(&publication.journal_id).unwrap().name,
                    publication.year
                ),
            )
            .with_container(inner_row);

        let outer_row = Container::default()
            .with_attributes([("class", "row row-grid pub_row")])
            .with_container(
                Container::default()
                    .with_attributes([("class", "row-same-height")])
                    .with_container(
                        Container::default()
                            .with_attributes([(
                                "class",
                                "pub_image_div col-md-4 col-sm-height col-middle",
                            )])
                            .with_image_attr(
                                format!("png/{}.png", publication.bibtex_key),
                                &publication.title,
                                [("class", "big-image")],
                            ),
                    )
                    .with_container(content),
            );

        html_str += _bibkey_dummy.to_html_string().as_ref();
        html_str += outer_row.to_html_string().as_ref();
    }
    html_str
}
