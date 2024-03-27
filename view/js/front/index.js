$(document).ready(function () {
  $(window).scroll(function () {
    $('.l-pos_fil_display').each(function (i) {
      var topOfElement = $(this).offset().top; // 要素の上端
      var elementHeight = $(this).outerHeight(); // 要素の高さ
      var bottomOfWindow = $(window).scrollTop() + $(window).height(); // ビューポートの下端

      // 要素の高さの20%がビューポート内に入ったかどうかを判定
      var triggerPoint = topOfElement + (elementHeight * 0.4); // トリガー点を計算

      if (bottomOfWindow > triggerPoint) {
        $(this).addClass('fadeIn');
      }
    });
  });
});
