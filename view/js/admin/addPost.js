$(document).ready(function() {
  var firstStep = $('.l-form_first_area');
  var secondStep = $('.l-form_second_area');
  var firstStepBtn = $('#firstStepBtn');
  var secondStepBtn = $('#secondStepBtn');

  firstStep.addClass('js-form_step_active');
  secondStep.addClass('js-form_step_right').removeClass('js-form_step_active');

  firstStepBtn.click(function() {
      firstStep.addClass('js-form_step_active').removeClass('js-form_step_left js-form_step_right');
      secondStep.addClass('js-form_step_right').removeClass('js-form_step_active');

      firstStepBtn.hide();
      secondStepBtn.show();
  });

  secondStepBtn.click(function() {
      firstStep.addClass('js-form_step_left').removeClass('js-form_step_active');
      secondStep.addClass('js-form_step_active').removeClass('js-form_step_left js-form_step_right');

      firstStepBtn.show();
      secondStepBtn.hide();
  });
});
