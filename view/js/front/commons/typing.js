// 画面がスクロールされたらアニメーションをチェック
$(window).scroll(function () {
  TextTypingAnime(); // アニメーション用の関数を呼ぶ
});

// 画面が読み込まれたらすぐにアニメーションをチェック
$(window).on('load', function () {
  prepareTextTyping();
  TextTypingAnime(); // アニメーション用の関数を呼ぶ
});

// spanタグを追加する処理を別の関数に分ける
function prepareTextTyping() {
  var element = $(".TextTyping");
  element.each(function () {
    var text = $(this).html();
    var textbox = "";
    text.split(/(<br>)/g).forEach(function (t) {
      if (t.match(/<br>/)) {
        textbox += t;
      } else {
        t.split('').forEach(function (char) {
          textbox += '<span style="display: none;">' + char + '</span>';
        });
      }
    });
    $(this).html(textbox);
  });
}

// アニメーション実行関数
function TextTypingAnime() {
  $('.TextTyping').each(function () {
    var thisPos = $(this).offset().top;
    var topOfWindow = $(window).scrollTop();
    if (thisPos < topOfWindow + $(window).height()) {
      $(this).find('span').each(function (i) {
        $(this).delay(100 * i).fadeIn(100);
      });
    }
  });
}

