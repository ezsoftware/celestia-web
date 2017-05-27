(function($) {
  var $fName = $('#input_1_4_3')
    , $lName = $('#input_1_4_6')
    , $name = $fName.add($lName)
    , $world = $('#input_1_5')
    , $all = $name.add($world);

  function searchPlayer() {
    var fName = $fName.val()
      , lName = $lName.val()
      , world = $world.val()
      , data = {
        action: 'cw_searchCharacter',
        first_name: fname,
        last_name: lname,
        server: world
      };

    $.post(ajaxurl, data)
      .done(function(response) {
        console.log(response);
      })
      .fail(function(response) {
        console.error(response);
      })
  }

  $name.blur()
})(jQuery);