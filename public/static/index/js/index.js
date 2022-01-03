$(function(){
  var bodyWidth=document.body.clientWidth;
  // 计算大页签定位
  var pageSignWaiNr=(bodyWidth-1200)/2;
  $('.pageSignWaiNr').css('left',pageSignWaiNr+'px');

  // 计算右侧悬浮定位及高度
  var bodyHeight=document.documentElement.clientHeight;

  $('.bodyRight').css({'height':bodyHeight+'px'});


  // 大页签
  $('.pageSignHead li').hover(function(){
      $(this).addClass('pageSHLActive');
      $('.pageSignHead li').not($(this)).removeClass('pageSHLActive');
      idx=$(this).index('.pageSignHead li');
      $('.pageSignNr').eq(idx).show();
      $('.pageSignNr').not($('.pageSignNr').eq(idx)).hide();
  });

  // 大页签右侧小页签
  $('.smailPSignHead li').hover(function(){
    $(this).addClass('smailPSignActive');
    $('.smailPSignHead li').not($(this)).removeClass('smailPSignActive');
    idx=$(this).index('.smailPSignHead li');
    $('.smailPSignNr li').eq(idx).show();
    $('.smailPSignNr li').not($('.smailPSignNr li').eq(idx)).hide();
  });

  // 底部页签+轮播->页签
  $('.swiperPHeadList').hover(function(){
    $(this).addClass('sPH_Active');
    $('.swiperPHeadList').not($(this)).removeClass('sPH_Active');
    idx=$(this).index('.swiperPHeadList');
    $('.isSwiperPageNr').eq(idx).show();
    $('.isSwiperPageNr').not($('.isSwiperPageNr').eq(idx)).hide();
  });

  // 底部页签+轮播->悬浮图片移动
  $('.swiperPageNrList a img').hover(
    function(){
      $(this).animate({
        left:'-100px'
      },400);
    },
    function(){
      $(this).animate({
        left:'0px'
      },400);
    }
  );

  // body右侧悬浮1
  $('.bodyRight .list_1').hover(
    function(){
      $(this).addClass('bodyRightActive');
      $('.bodyRight .BractiveNr_1').show();
      
      $('.bodyRight .BractiveNr_1').animate({
        left:'-109px',
        opacity:'1'
      },200);
    },
    function(){
      $(this).removeClass('bodyRightActive');

      $('.bodyRight .BractiveNr_1').animate({
        left:'-180px',
        opacity:'0'
      },200,function(){
        $('.bodyRight .BractiveNr_1').hide();
      });
    }
  );

  // body右侧悬浮2
  $('.bodyRight .list_2').hover(
    function(){
      $(this).addClass('bodyRightActive');
    },
    function(){
      $(this).removeClass('bodyRightActive');
    }
  );

  // body右侧悬浮3
  $('.bodyRight .list_3').hover(
    function(){
      $(this).addClass('bodyRightActive');
      $('.bodyRight .BractiveNr_3').show();
      
      $('.bodyRight .BractiveNr_3').animate({
        left:'-109px',
        opacity:'1'
      },200);
    },
    function(){
      $(this).removeClass('bodyRightActive');

      $('.bodyRight .BractiveNr_3').animate({
        left:'-180px',
        opacity:'0'
      },200,function(){
        $('.bodyRight .BractiveNr_3').hide();
      });
    }
  );

  // body右侧悬浮4
  $('.bodyRight .list_4').hover(
    function(){
      $(this).addClass('bodyRightActive');
      $('.bodyRight .BractiveNr_4').show();
      
      $('.bodyRight .BractiveNr_4').animate({
        left:'-109px',
        opacity:'1'
      },200);
    },
    function(){
      $(this).removeClass('bodyRightActive');

      $('.bodyRight .BractiveNr_4').animate({
        left:'-180px',
        opacity:'0'
      },200,function(){
        $('.bodyRight .BractiveNr_4').hide();
      });
    }
  );

  // body右侧悬浮5
  $('.bodyRight .list_5').hover(
    function(){
      $(this).addClass('bodyRightActive');
      $('.bodyRight .BractiveNr_5').show();
      
      $('.bodyRight .BractiveNr_5').animate({
        left:'-196px',
        opacity:'1'
      },200);
    },
    function(){
      $(this).removeClass('bodyRightActive');

      $('.bodyRight .BractiveNr_5').animate({
        left:'-278px',
        opacity:'0'
      },200,function(){
        $('.bodyRight .BractiveNr_5').hide();
      });
    }
  );

  // body右侧悬浮6
  $('.bodyRight .list_6').hover(
    function(){
      $(this).addClass('bodyRightActive');
      $('.bodyRight .BractiveNr_6').show();
      
      $('.bodyRight .BractiveNr_6').animate({
        left:'-234px',
        opacity:'1'
      },200);
    },
    function(){
      $(this).removeClass('bodyRightActive');

      $('.bodyRight .BractiveNr_6').animate({
        left:'-316px',
        opacity:'0'
      },200,function(){
        $('.bodyRight .BractiveNr_6').hide();
      });
    }
  );

  // body右侧悬浮7
  $('.bodyRight .list_7').hover(
    function(){
      $(this).addClass('bodyRightActive');
      $('.bodyRight .BractiveNr_7').show();
      
      $('.bodyRight .BractiveNr_7').animate({
        left:'-109px',
        opacity:'1'
      },200);
    },
    function(){
      $(this).removeClass('bodyRightActive');

      $('.bodyRight .BractiveNr_7').animate({
        left:'-180px',
        opacity:'0'
      },200,function(){
        $('.bodyRight .BractiveNr_7').hide();
      });
    }
  );

  // body右侧悬浮8
  $('.bodyRight .list_8').hover(
    function(){
      $(this).addClass('bodyRightActive');
      $('.bodyRight .BractiveNr_8').show();
      
      $('.bodyRight .BractiveNr_8').animate({
        left:'-109px',
        opacity:'1'
      },200);
    },
    function(){
      $(this).removeClass('bodyRightActive');

      $('.bodyRight .BractiveNr_8').animate({
        left:'-180px',
        opacity:'0'
      },200,function(){
        $('.bodyRight .BractiveNr_8').hide();
      });
    }
  );

  // body右侧悬浮t
  $('.bodyRight .list_t').hover(
    function(){
      $(this).addClass('bodyRightActive');
      $('.bodyRight .BractiveNr_t').show();
      
      $('.bodyRight .BractiveNr_t').animate({
        left:'-109px',
        opacity:'1'
      },200);
    },
    function(){
      $(this).removeClass('bodyRightActive');

      $('.bodyRight .BractiveNr_t').animate({
        left:'-180px',
        opacity:'0'
      },200,function(){
        $('.bodyRight .BractiveNr_t').hide();
      });
    }
  );

  // 小轮播
  function newsCarousel(animateSpeed, timerSpeed, className) {
    var $key = 0;
    var $circle = 0;
    $("." + className + " .ulList li:first").clone().appendTo($("." + className + " .ulList"));
    $("." + className + " .next").click(function(event) {
      autop()
    });
    $("." + className + " .prev").click(function(event) {
      $key--;
      if ($key < 0) {
        $key = $("." + className + " .ulList li").length - 2;
        $("." + className + " .ulList").css("left", -($("." + className + " .ulList li").length - 1) * $("." + className + " .ulList li").width());
      }
      $("." + className + " .ulList").stop().animate({
        "left": -$key * $("." + className + " .ulList li").width()
      },
      animateSpeed);
      $circle--;
      $circle < 0 ? $circle = $("." + className + " .olBar li").length - 1 : $circle;
      $("." + className + " .olBar li").eq($circle).addClass('current').siblings().removeClass('current');
      $("." + className + " .dot li").eq($circle).addClass('cur').siblings().removeClass('cur');
    });
    $("." + className + " .dot li").click(function(event) {
      $key = $(this).index();
      $circle = $(this).index();
      $(this).addClass("cur").siblings().removeClass('cur');
      $("." + className + " .ulList").stop().animate({
        "left": -$key * $("." + className + " .ulList li").width()
      },
      animateSpeed);
      $("." + className + " .olBar li").eq($circle).addClass('current').siblings().removeClass('current');
    });
    var timer = setInterval(autop, timerSpeed);
    function autop() {
      $key++;
      if ($key > $("." + className + " .ulList li").length - 1) {
        $key = 1;
        $("." + className + " .ulList").css("left", 0);
      }
      $("." + className + " .ulList").stop().animate({
        "left": -$key * $("." + className + " .ulList li").width()
      },
      animateSpeed);
      $circle++;
      $circle > $("." + className + " .olBar li").length - 1 ? $circle = 0 : $circle;
      $("." + className + " .olBar li").eq($circle).addClass('current').siblings().removeClass('current');
      $("." + className + " .dot li").eq($circle).addClass('cur').siblings().removeClass('cur');
    }
    $("." + className).hover(function() {
      clearInterval(timer);
      timer = null;
    },
    function() {
      clearInterval(timer);
      timer = setInterval(autop, timerSpeed);
    });
  }

  // 小轮播1
  $(function() {
    newsCarousel(400, 3000, 'newsCarousel1');
  });

  // 小轮播2
  $(function() {
    newsCarousel(400, 3000, 'newsCarousel2');
  });

  // 优惠推荐
  $(function() {
    newsCarousel(1000, 5000, 'newsCarousel3');
  });

  // 重复内容左轮播1
  $(function() {
    var isRepeat=(298-parseInt($('.repeat1 .repeatMr').css('width')))/2;
    $('.repeat1 .repeatMr').css('margin-right',isRepeat+'px')
    newsCarousel(400, 5000, 'repeat1');
  });

  // 重复内容右轮播1
  $(function() {
    var isRepeat=(268-parseInt($('.repeatR1 .repeatMr').css('width')))/2;
    $('.repeatR1 .repeatMr').css('margin-right',isRepeat+'px')
    newsCarousel(400, 5000, 'repeatR1');
  });

  // 重复内容左轮播2
  $(function() {
    var isRepeat=(298-parseInt($('.repeat2 .repeatMr').css('width')))/2;
    $('.repeat2 .repeatMr').css('margin-right',isRepeat+'px')
    newsCarousel(400, 5000, 'repeat2');
  });

  // 重复内容右轮播2
  $(function() {
    var isRepeat=(268-parseInt($('.repeatR2 .repeatMr').css('width')))/2;
    $('.repeatR2 .repeatMr').css('margin-right',isRepeat+'px')
    newsCarousel(400, 5000, 'repeatR2');
  });

  // 重复内容左轮播3
  $(function() {
    var isRepeat=(298-parseInt($('.repeat3 .repeatMr').css('width')))/2;
    $('.repeat3 .repeatMr').css('margin-right',isRepeat+'px')
    newsCarousel(400, 5000, 'repeat3');
  });

  // 重复内容右轮播3
  $(function() {
    var isRepeat=(268-parseInt($('.repeatR3 .repeatMr').css('width')))/2;
    $('.repeatR3 .repeatMr').css('margin-right',isRepeat+'px')
    newsCarousel(400, 5000, 'repeatR3');
  });

  // 重复内容左轮播4
  $(function() {
    var isRepeat=(298-parseInt($('.repeat4 .repeatMr').css('width')))/2;
    $('.repeat4 .repeatMr').css('margin-right',isRepeat+'px')
    newsCarousel(400, 5000, 'repeat4');
  });

  // 重复内容右轮播4
  $(function() {
    var isRepeat=(268-parseInt($('.repeatR4 .repeatMr').css('width')))/2;
    $('.repeatR4 .repeatMr').css('margin-right',isRepeat+'px')
    newsCarousel(400, 5000, 'repeatR4');
  });

  // 重复内容左轮播5
  $(function() {
    var isRepeat=(298-parseInt($('.repeat5 .repeatMr').css('width')))/2;
    $('.repeat5 .repeatMr').css('margin-right',isRepeat+'px')
    newsCarousel(400, 5000, 'repeat5');
  });

  // 重复内容右轮播5
  $(function() {
    var isRepeat=(268-parseInt($('.repeatR5 .repeatMr').css('width')))/2;
    $('.repeatR5 .repeatMr').css('margin-right',isRepeat+'px')
    newsCarousel(400, 5000, 'repeatR5');
  });

  // 重复内容左轮播6
  $(function() {
    var isRepeat=(298-parseInt($('.repeat6 .repeatMr').css('width')))/2;
    $('.repeat6 .repeatMr').css('margin-right',isRepeat+'px')
    newsCarousel(400, 5000, 'repeat6');
  });

  // 重复内容右轮播6
  $(function() {
    var isRepeat=(268-parseInt($('.repeatR6 .repeatMr').css('width')))/2;
    $('.repeatR6 .repeatMr').css('margin-right',isRepeat+'px')
    newsCarousel(400, 5000, 'repeatR6');
  });

  // 底部页签+录播->轮播
  $(function() {
    var isRepeat=(268-parseInt($('.swiperPageNr1 .repeatMr').css('width')))/2;
    $('.swiperPageNr1 .repeatMr').css('margin-right',isRepeat+'px')
    newsCarousel(400, 5000, 'swiperPageNr1');
  });
});
