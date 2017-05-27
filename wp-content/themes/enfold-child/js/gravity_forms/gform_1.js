(function($) {
  var $fName = $('#input_1_4_3')
    , $lName = $('#input_1_4_6')
    , $name = $fName.add($lName)
    , $world = $('#input_1_5')
    , $all = $name.add($world);

  function searchPlayer(fname, lname, world) {
    var data = {
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

  $name.blur(function() {
    var fname = $fName.val()
      , lname = $lName.val()
      , world = $world.val();

    if(fname.length > 0, lname.length > 0, world.length > 0) {
      searchPlayer(fname, lname, world);
    }
  })
})(jQuery);