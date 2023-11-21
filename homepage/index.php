<!DOCTYPE html>
<html lang="en-GB">

	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<title>Dan Koschier, PhD</title>
		<meta name="author" content="Dan Koschier" />
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>

	<link rel="stylesheet" type="text/css" href="css/layout.css" />

	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css' />
	<link href='https://fonts.googleapis.com/css?family=Ubuntu+Mono' rel='stylesheet' type='text/css' />
	<script src="js/scroll.js"></script>
	<script src="js/maps.js"></script>

	<body>
		<!-- <div id="id_wrapper"> -->
		<header>
			<!-- Logo -->
			<div class="ud_logo" id="id_logo"><span>Dan Koschier</span></div>

			<!-- Navigation -->
			<nav>
				<ul>
					<li><a href="#id_home">Home</a></li>
					<li><a href="#id_publications">Publications</a></li>
					<li><a href="#id_contact">Contact</a></li>
				</ul>
			</nav>

		</header>


		<!-- Website -->
		<!-- <section id="id_wrapper"> -->

		<!-- Home -->
		<section id="id_home" class="ud_page">

			<h2>Home</h2>
			<div class="ud_h2_separator"></div>

			<div class="container">
				<div class="row row-grid">
					<div class="row-same-height">
						<div class="col-sm-6 col-md-6 cols-xs-12 col-sm-height col-middle">
							<img src="png/koschier_wide.png"class="big-image" style="display: block; height: auto; width: 100%;" />
						</div>
						<div class="col-sm-6 col-md-6 cols-xs-12 col-sm-height col-middle">
							<p>Currently I am a Software Engineer at <a href="http://www.facebook.com">Facebook</a>. Prior to that I've worked in R&amp;D at <a href="http://www.visionrt.com">Vision RT</a> in Medical Technology and was a Research Associate at the <a href="http://geometry.cs.ucl.ac.uk/">Smart Geometry Processing Group</a> at University College London, UK.
							I received my PhD from RWTH Aachen University where I was a member of the <a href="https://www.animation.rwth-aachen.de">Animation Group</a> at the Visual Computing Institute. Further, I received my MSc degree in Computational Engineering from TU Darmstadt, Germany.</p>
							<div class="account-link-container row">
								<div class="col-xs-3">
									<a href="https://scholar.google.co.uk/citations?user=0evsBC4AAAAJ">
										<img class="account-image" src="png/google_scholar.svg" alt="github"/>
									</a>
								</div>
								<div class="col-xs-3">
									<a href="https://github.com/dankoschier">
										<img class="account-image" src="png/github.svg" alt="github"/>
									</a>
								</div>
								<div class="col-xs-3">
									<a href="https://www.researchgate.net/profile/Dan_Koschier">
										<img class="account-image" src="png/researchgate.svg" alt="researchgate"/>
									</a>
								</div>
								<div class="col-xs-3">
									<a href="https://www.linkedin.com/in/dankoschier">
										<img class="account-image" src="png/linkedin.png" alt="linkedin"/>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!--  Publications -->
		<section id="id_publications" class="ud_page">
			<!-- <h2>Projects</h2>
			<div class="ud_h2_separator"></div> -->

			<h2>Publications</h2>
			<div class="ud_h2_separator"></div>
			<div id="publication_list" class="container">
				<?php
				ini_set('display_errors',1);
				error_reporting(E_ALL | E_STRICT);
				$servername = "dankoschier.de";
				$username = "dan";
				$password = "foxtrot88";
				$dbname = "publications";
				$dbport = "3306";
				$conn = new mysqli($servername, $username, $password, $dbname, $dbport);
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}

				$sql = "SELECT
					BibtexKey,
					Title,
					Year,
					Youtube,
					Annotation,
					Bibtex,
					FileURL,
					A1.FirstName as FirstName1,
					A1.LastName as LastName1,
					A1.URL as URL1,
					A2.FirstName as FirstName2,
					A2.LastName as LastName2,
					A2.URL as URL2,
					A3.FirstName as FirstName3,
					A3.LastName as LastName3,
					A3.URL as URL3,
					A4.FirstName as FirstName4,
					A4.LastName as LastName4,
					A4.URL as URL4,
					A5.FirstName as FirstName5,
					A5.LastName as LastName5,
					A5.URL as URL5,
					A6.FirstName as FirstName6,
					A6.LastName as LastName6,
					A6.URL as URL6,
					J.Name as JournalName,
					J.Priority as Priority
					FROM Publications P
					LEFT JOIN Authors A1 ON P.Author1 = A1.ID
					LEFT JOIN Authors A2 ON P.Author2 = A2.ID
					LEFT JOIN Authors A3 ON P.Author3 = A3.ID
					LEFT JOIN Authors A4 ON P.Author4 = A4.ID
					LEFT JOIN Authors A5 ON P.Author5 = A5.ID
					LEFT JOIN Authors A6 ON P.Author6 = A6.ID
					LEFT JOIN Journals J ON P.Journal = J.ID
					ORDER BY Year DESC, Priority DESC
					";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					// output data of each row
					while($row = $result->fetch_assoc()) {

					$author_str = "";
					for ($i = 1; $i <= 6; $i++) {
						if ($row["LastName" . $i] != "") {
							$author_add = $row["FirstName" . $i] . " " . $row["LastName" . $i];
							if ($row["URL" . $i] != "") {
								$author_add = '<a href="' . $row["URL" . $i] . '" class="author-link">' . $author_add . '</a>';
							}
							if ($author_str != "")
							{
								$author_str = $author_str . ", ";
							}
							$author_str = $author_str . $author_add;
						}
					}
					$bibkey = $row["BibtexKey"];
					$title = $row["Title"];
					$journal = $row["JournalName"];
					$annot = $row["Annotation"];
					$year = $row["Year"];
					$bibtex = $row["Bibtex"];
					$file = $row["FileURL"];
					if ($file === null) {
						$file = "resources/papers/" . $row["BibtexKey"] . ".pdf";
					}
					$yt = $row["Youtube"];
					$icon_size = 32;

					$nfields = "6";
					if ($yt != "") {
						$nfields = "4";
					}

					echo '
					<div class="bibkey-dummy" id="' . $bibkey . '" ytcode="' . $yt . '" bibtex="' . $bibtex . '"></div>
					<div class="row row-grid pub_row">
						<div class="row-same-height">
							<div class="pub_image_div col-md-4 col-sm-height col-middle">
								<img class="big-image" alt="' . $title . '" src="png/' . $bibkey . '.png">
							</div>
							<div class="col-md-8 pub_description col-sm-height col-middle">
								<h3>' . $title . '</h3>
								<h4>' . $author_str . '</h4>
								<h4>' . $journal . ' (' . $year . ')' . '</h4>
								' . ($annot != "" ? '<h4>' . $annot . '</h4>' : '') . '
								<div class="row material-block">
									<div class="col-xs-' . $nfields . ' material-link">
										<a href="' . $file . '" id=pdf_link_' . $bibkey . '>
											<img id="pdf_icon_' . $bibkey . '" alt="pdf" src="png/document_icon.svg" width=' . $icon_size . ' height=' . $icon_size . '>
										</a>
									</div>
					';
					if ($yt != "") {
						echo '
									<div class="col-xs-4 material-link">
										<img class="video-icon" id="video_icon_' . $bibkey . '" alt="video" src="png/video_icon.svg" width=' . $icon_size . ' height=' . $icon_size . '>
									</div>
						';
					}
					echo '
									<div class="col-xs-' . $nfields . ' material-link">
										<img id="cite_icon_' . $bibkey . '" alt="cite" src="png/cite_icon.svg" width=' . $icon_size . ' height=' . $icon_size . '>
									</div>
								</div>
							</div>
						</div>
					</div>
					';
					}
				} else {
					echo "0 results";
				}
				$conn->close();
				?>
			</div>

			<div id="bibtex_frame" class="bibtex" hidden=true>
			</div>

			<div id="overlay" class="overlay" hidden=true></div>
			<iframe id="yt" class="yt" src="https://www.youtube.com/embed/x_Iq2yM4FcA" frameborder="0" allowfullscreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen" msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen"
				webkitallowfullscreen="webkitallowfullscreen"  allowscriptaccess="always"></iframe>

		</section>

		<section id="id_contact" class="ud_page">
			<h2>Contact</h2>
			<div class="ud_h2_separator"></div>

			<article class="ud_contact">
				<ul>
					<!--
					<li>
						<div class="ud_contact_phone">+44 (0) 20 310 871 35</div>
					</li>
					-->
					<li>
						<div class="ud_contact_mail">
							<script language="JavaScript">
								var username = "dkosc";
								var hostname = "fb.com";
								var linktext = username + "@" + hostname;
								document.write("<a href='" + "ma" + "il" + "to:" + username + "@" + hostname + "'>" + linktext + "</a>");
							</script>
						</div>
					</li>
					<li>
						<div class="ud_contact_location">
							<!--Room x.xx
							<br />-->10 Brock Street
							<br />London NW1 3FG, UK
						</div>
					</li>
				</ul>
				<div id="id_map"></div>
				<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNvJ3quhH_Zuq4wZBz9PDH8BBM-h4I_YY&callback=initMap"></script>
			</article>

			<!-- Footer -->
			<footer>
			</footer>

		</section>
		<!-- </div> -->
	</body>

</html>
</a>
</div>
</footer>

</section>
<!-- </div> -->
</body>

</html>
