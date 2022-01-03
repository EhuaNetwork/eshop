function bra() {
    var t = $(".gjw-wrapper").length,
    a = {
        Count: t,
        id: 0,
        num: 0,
        init: function() {
            $div = $(".swiper-container");
            for (var i = "",
            a = 0; a < t; a++) i += '<span class="swiper-index" style="background:' + (0 == a ? "red": "") + ';"  data-id="' + (t - a) + '">' + (a + 1) + "</span>";
            var n = '   <div class="controllbox"><div class="swiper-pagination">' + i + '</div><div class="swiper-button-prev prevbtn1"></div><div class="swiper-button-next nextbtn1"></div></div>';
            $div.append(n)
        },
        jump: function(i) {
            $(".gjw-wrapper ").css({
                position: "relative",
                margin: "0 auto",
                display: "none"
            }),
            $(".swiper-index").css({
                background: ""
            }),
            i < t - 1 ? ($(".swiper-index").eq(parseInt(i) + 1).css({
                background: "red"
            }), $(".bractive ").css({
                position: "absolute",
                display: "block"
            }).fadeOut(500), $(".bractive").removeClass("bractive"), $(".gjw-wrapper ").eq(parseInt(i) + 1).addClass("bractive"), $(".bractive").css({
                position: "absolute"
            }).fadeIn(500)) : ($(".swiper-index").eq(0).css({
                background: "red"
            }), $(".bractive").css({
                position: "absolute",
                display: "block"
            }).fadeOut(500), $(".bractive").removeClass("bractive"), $(".gjw-wrapper ").eq(0).addClass("bractive"), $(".bractive").css({
                position: "absolute"
            }).fadeIn(500))
        },
        Bra_setInterval: function(i) {
            $this = this,
            clearInterval(this.id),
            this.id = setInterval(function() {
                $this.jump(i),
                i++,
                i === t && (i = 0),
                $this.num = i
            },
            3e3)
        },
        nextbtn: function() {
            clearInterval(this.id),
            i++,
            i === t && (i = 0),
            this.num = i,
            this.jump(this.num)
        },
        prevBtn: function() {
            return i--,
            i < 0 && (i = t - 1),
            this.num = i,
            this.jump(this.num),
            this.num
        },
        run: function() {
            this.init(),
            i = 0,
            this.Bra_setInterval(i)
        }
    };
    $(".gjw-wrapper img").hover(function() {
        clearInterval(ksy.id)
    },
    function() {
        ksy.Bra_setInterval(ksy.num)
    }),
    $(".swiper-container").on("click", ".swiper-index",
    function() {
        var t = $(this).data("id"),
        i = ksy.Count - 1 - t >= 0 ? ksy.Count - 1 - t: ksy.Count - 1;
        clearInterval(ksy.id),
        ksy.jump(i)
    }),
    $(".swiper-container").on("mouseenter", ".swiper-index",
    function() {
        var t = $(this).data("id"),
        i = ksy.Count - 1 - t >= 0 ? ksy.Count - 1 - t: ksy.Count - 1;
        clearInterval(ksy.id),
        ksy.jump(i)
    }),
    $(".swiper-container").on("click", ".prevbtn1",
    function() {
        clearInterval(ksy.id),
        ksy.prevBtn()
    }),
    $(".swiper-container").on("click", ".nextbtn1",
    function() {
        clearInterval(ksy.id),
        ksy.nextbtn()
    }),
    $(".swiper-container").on("mouseout", ".swiper-pagination",
    function() {
        ksy.Bra_setInterval(ksy.num)
    }),
    a.run(),
    window.ksy = a
}
function run(){

}
$(function() {
    placeName = "茅台飞天",
    "/Search.html" == location.pathname && (placeName = decodeURI(location.search.split("&")[0].split("=")[1])),
    $(".swiper-wrapper img").eq(0).css("display", "block");
    var t;
    $(".focusbtn").mouseenter(function() {
        $(".ewm").css("display", "block"),
        clearTimeout(t)
    }),
    $(".focusbtn").mouseleave(function() {
        t = setTimeout(function() {
            $(".ewm").css("display", "none")
        },
        100)
    });
    var i = new Swiper(".swiper-container-dztj", {
        autoplay: 2e3,
        autoplayDisableOnInteraction: !1,
        nextButton: ".swiper-button-next",
        prevButton: ".swiper-button-prev"
    });
    if ($(".swiper-slide").mouseenter(function() {
        i.stopAutoplay()
    }), "/" == location.pathname) {
        GetLink();
        setInterval(function() {
            var t = $(".friendLinkList").css("top"),
            i = t.substring(0, t.length - 2) - 32 + "px";
            $(".friendLinkList").animate({
                top: i
            },
            1e3,
            function() {
                t.substring(0, t.length - 2) < 0 && $(".friendLinkList").css("top", 0)
            })
        },
        2e3)
    } else $(".frendLinkBox").remove()
});
var b = new bra;