

$(function() {
	$('a[href*=\\#]').stop().click(function() {
		if (location.pathname.replace(/^\//,'') === this.pathname.replace(/^\//,'') && location.hostname === this.hostname) {
			var hash = this.hash;
			var target = $(hash);
			if (target.length) {
				var top_margin = target.offset().top;
				$('html,body').animate({scrollTop: top_margin}, 1000, function(){
					window.location.hash = hash;
				});
				return false;
			}
		}
	});
});

$(function() {
	$(document).keyup(function(e) {
		if (e.which == 27)
		{
			overlay = document.getElementById("overlay");
			overlay.style.display = "none";
			yt = document.getElementById("yt");
			$('.yt').each(function(index) {
				$(this).attr('src', "https://www.youtube.com/embed/x_Iq2yM4FcA");
				return false;
			});

			yt.style.display = "none";
			[].forEach.call(document.getElementsByClassName("bibtex"), function(item)
			{
				item.style.display = "none";
			});
		}
	});
	document.getElementById("overlay").onclick = function() {
	    document.getElementById("overlay").style.display = "none";
	    var iframe = document.getElementById("yt");
	    $('.yt').each(function(index) {
	        $(this).attr('src', "https://www.youtube.com/embed/x_Iq2yM4FcA");
	        return false;
	    });

	    iframe.style.display = "none";
	    [].forEach.call(document.getElementsByClassName("bibtex"), function(item)
	    {
	        item.style.display = "none";
	    });
	};
});

$(function() {
	$(".bibkey-dummy").each(function(i, obj) {

		var video_icon = document.getElementById("video_icon_" + obj.id);
		if (video_icon)
		{
			var yt_code = obj.getAttribute("ytcode");
			video_icon.onclick = function() {
				overlay = document.getElementById("overlay");
				overlay.style.display = "block";

				yt = document.getElementById("yt");
				yt.setAttribute("src", "https://www.youtube.com/embed/" + yt_code + "?autoplay=1&origin=https://github.dankoschier.io");
				yt.style.display = "block";
			};
		}

		var cite_icon = document.getElementById("cite_icon_" + obj.id);
		cite_icon.onclick = function() {
			overlay = document.getElementById("overlay");
			overlay.style.display = "block";

			var bf = document.getElementById("bibtex_frame");
			if (bf)
			{
				bf.style.display = "block";
				bf.innerHTML = "<pre>" + obj.getAttribute("bibtex") + "</pre>";
			}
		}
	});
});
