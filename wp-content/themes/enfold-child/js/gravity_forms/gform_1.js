(function($) {
  var ajaxurl = '/wp-admin/admin-ajax.php'
    , $fName = $('#input_1_4_3')
    , $lName = $('#input_1_4_6')
    , $name = $fName.add($lName)
    , $world = $('#input_1_5')
    , $found = $('#input_1_6')
    , $all = $name.add($world);

  function searchPlayer(fname, lname, world) {
    var overlay = document.createElement('div');
    overlay.className = 'overlay';
    overlay.innerHTML = "<div class='overlay-text'><span class='overlay-loader'></span> Searching Lodestone for your Character...</div>";
    $(overlay).appendTo($('body'));

    var data = {
        action: 'cw_searchCharacter',
        first_name: fname,
        last_name: lname,
        server: world
      };

    $.post(ajaxurl, data)
      .done(function(response) {
        var s_data = JSON.parse(response);
        if(s_data.length == 0) {
          $found.val('false');
        } else {
          for(var i = 0; i < s_data.length; i++) {
            if(s_data.name == (fname + " " + lname)) {

              var playerContainer = document.createElement("li");
              var playerImage = document.createElement('img');
              var playerName = document.createElement('span');
              var playerWorld = document.createElement('span');
              var playerFC = document.createElement('span');

              playerContainer.className = "player-box";
              playerImage.src = "/wp-content/themes/enfold-child/image_proxy.php?url=" + s_data.face;
              playerName.innerHTML = s_data.name;
              playerWorld.innerHTML = s_data.world;
              playerFC.innerHTML = s_data.free_company;

              $('#field_1_4').after(playerContainer);
              $('#input_6').val(s_data.character_id);
            }
          }
        }
        $('.overlay').remove();
        console.log(s_data);
      })
      .fail(function(response) {
        console.error(response);
      })
  }

  $name.blur(_.debounce(function() {
    var fname = $fName.val()
      , lname = $lName.val()
      , world = $world.val();

    if(fname.length > 0 && lname.length > 0 && world.length > 0) {
      searchPlayer(fname, lname, world);
    }
  }));
})(jQuery);