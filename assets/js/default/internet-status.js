(function ($) {
    'use strict';

    // :: Internet Connection Detect
    var internetStatus = $("#internetStatus"),
        onlineText = "Yeey! Anda Kembali Online",
        offlineText = "Tidak Ada Koneksi Internet!";

    if (window.navigator.onLine) {
        internetStatus.css("display", "none").text(onlineText).addClass("internet-is-back").removeClass("internet-is-lost");
    } else {
        internetStatus.css("display", "block").text(offlineText).addClass("internet-is-lost").removeClass("internet-is-back");
    }

    window.addEventListener('offline', function () {
        internetStatus.text(offlineText).addClass("internet-is-lost").removeClass("internet-is-back").fadeIn(500);
        var anchors = document.getElementsByTagName("a");
        for (var i = 0; i < anchors.length; i++) {
            anchors[i].onclick = function() {return(false);};
        }
    });

    window.addEventListener('online', function () {
        internetStatus.text(onlineText).addClass("internet-is-back").removeClass("internet-is-lost").delay("5000").fadeOut(500);
        var anchors = document.getElementsByTagName("a");
        for (var i = 0; i < anchors.length; i++) {
            anchors[i].onclick = function() {return(true);};
        }
    });

    $(".offline-detection").on("click", function () {
        internetStatus.text(offlineText).addClass("internet-is-lost").removeClass("internet-is-back").fadeIn(500).delay("3000").fadeOut(500);
    });

    $(".online-detection").on("click", function () {
        internetStatus.text(onlineText).addClass("internet-is-back").removeClass("internet-is-lost").fadeIn(500).delay("3000").fadeOut(500);
    });

})(jQuery);