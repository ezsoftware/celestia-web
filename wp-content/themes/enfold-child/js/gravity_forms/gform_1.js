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
    overlay.innerHTML = "<div class='overlay-text-container'><span class='overlay-loader'></span><span class='overlay-text'>Searching Lodestone for your Character...</span></div>";
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
            var p_data = s_data[i];
            if(p_data.name == (fname + " " + lname)) {
              var playerContainer = document.createElement("li")
                , playerImage = document.createElement('img')
                , playerName = document.createElement('span')
                , playerWorld = document.createElement('span')
                , playerFC = document.createElement('span');

              playerContainer.className = "player-box";
              playerImage.src = "/image_proxy.php?url=" + encodeURIComponent(p_data.face);
              playerName.innerHTML = p_data.name;
              playerWorld.innerHTML = p_data.world;
              playerFC.innerHTML = p_data.free_company;

              playerContainer.appendChild(playerImage);
              playerContainer.appendChild(playerName);
              playerContainer.appendChild(playerWorld);
              playerContainer.appendChild(playerFC);

              $(playerContainer).insertAfter($('li#field_1_4'));
              $('#input_1_6').val(p_data.id);
            }
          }
        }
        $('.overlay').remove();
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