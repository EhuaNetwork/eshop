$(function(){
  // 左上角APP悬浮
  $('.headerNrLeft').hover(
    function(){
      $('.headerNrLeft .headerNrLCode img').addClass('headerNrLeftImg');
      $('.headerNrLeft .headerNrLArrow img').addClass('headerNrLeftImg');
      $('.APPDW').show();
    },
    function(){
      $('.headerNrLeft .headerNrLCode img').removeClass('headerNrLeftImg');
      $('.headerNrLeft .headerNrLArrow img').removeClass('headerNrLeftImg');
      $('.APPDW').hide();
    }
  );

  // 悬浮购物车
  $('.cartIs').hover(
    function(){
      $('.cartTcWai').show();
    },
    function(){
      $('.cartTcWai').hide();
    }
  );

  // 左侧列表悬浮
  $('.listnav').hover(
    function(){
      $(".qbfl-list").show()
    },
    function(){
      $(".qbfl-list").hide()
    }
  );
});

//foot滚动
var h=$(".friendship").height();
$(".friendship li").each(function(){
    $(this).css({top:$(this).index()*h+'px'});
});
setInterval(ctxtslide,2000);   //定时器分开写
function ctxtslide() {
  var disapear=$(".friendship li").first();
  var clone=$(".friendship li").first().clone();//克隆，后面就用这个克隆的
  clone.css({top:($(".friendship li").length*h)+"px"});
  $(".friendship").append(clone);
  $(".friendship li").each(function(){
    var top=parseInt($(this).css('top'));
    top-=h;
    $(this).animate({"top":top+'px'},1000,function () {
      disapear.remove();
    });
  });
}


