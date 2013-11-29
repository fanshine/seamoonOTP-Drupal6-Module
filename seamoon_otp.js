$(function() {

  $("form#seamoon-otp-key-pair-form #edit-otp-code").live("keypress", function() {
    var num = $(this).val();
    //console.info( num.length );
    if ( num.length == 3 ) $(this).val( num.substring(3,0) + " " + num.substring(6,3) )
  })

  $("form#seamoon-otp-key-login-form #edit-otp-code").live("keypress", function() {
    var num = $(this).val();
    if ( num.length == 3 ) $(this).val( num.substring(3,0) + " " + num.substring(6,3) )
  })

  if ( ($("form#seamoon-otp-key-login-form").length > 0) || $("body.otp.mandatory form#seamoon-otp-key-pair-form").length > 0 ) {
    $('a:not("a.close")').click(function(e) {
      e.preventDefault();
      window.alert('Insert OTP password');
    })
  }

});
