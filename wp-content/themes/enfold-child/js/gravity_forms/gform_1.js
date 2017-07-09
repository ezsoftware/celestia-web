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
    $('li.player-box').remove();
    $('#input_1_6').val('');
    $('#input_1_8').val('');

    var data = {
        action: 'cw_searchCharacter',
        first_name: fname.replace('\'', '{apostrophe}'),
        last_name: lname.replace('\'', '{apostrophe}'),
        server: world
      };

    $.post(ajaxurl, data)
      .done(function(response) {
        var s_data = JSON.parse(response);
        var bFound = false;
        for(var i = 0; i < s_data.length; i++) {
          var p_data = s_data[i];
          if(p_data.name == (fname + " " + lname)) {  
            bFound = true;            
            $.post(ajaxurl, {
              action: 'cw_getCharacterProfile',
              character_id: p_data.id
            }).done(function(char_data_response) {
              var profile = JSON.parse(char_data_response)
                , playerContainer = document.createElement("li")
                , playerImage = document.createElement('img')
                , playerName = document.createElement('span')
                , playerTitle = document.createElement('span')
                , playerWorld = document.createElement('span')
                , playerFC = document.createElement('span')
                , profileData = document.createElement('div');

              playerName.className = 'player-name';
              playerTitle.className = 'player-title';
              playerWorld.className = 'player-world';
              playerFC.className = 'player-fc';
              profileData.className = "player-classes";

              playerContainer.className = "player-box";
              playerImage.src = "/image_proxy.php?url=" + encodeURIComponent(p_data.face);
              playerName.innerHTML = p_data.name;
              playerTitle.innerHTML = "&lt;&#8226; " + profile.title + " &#8226;&gt;";
              playerWorld.innerHTML = p_data.world;
              playerFC.innerHTML = p_data.free_company;

              playerContainer.appendChild(playerImage);
              playerContainer.appendChild(playerName);
              playerContainer.appendChild(playerTitle);
              playerContainer.appendChild(playerWorld);
              playerContainer.appendChild(playerFC);                

              for(var key in profile.classes) {
                var classContainer = document.createElement('div')
                  //, className = document.createElement('span')
                  , classLevel = document.createElement('span')
                  , keys = key.split('/')
                  , classJob = keys.toString().trim().toLowerCase().replace(' ', '_');
                classContainer.className = 'class-level ' + classJob + (profile.classes[key] >= 70 ? ' capped' : '');
                classContainer.setAttribute('title', key);
                //className.innerHTML = key;
                classLevel.innerHTML = profile.classes[key];
                //classContainer.appendChild(className);
                classContainer.appendChild(classLevel);
                profileData.appendChild(classContainer);
              }
              playerContainer.appendChild(profileData);
              $(playerContainer).insertAfter($('li#field_1_4'));

              $('#input_1_6').val(p_data.id);
              $('#input_1_8').val(char_data_response);
              $('.overlay').remove();
            });
			      break;
          }
        }
        if(!bFound) {
          var playerContainer = document.createElement("li");
          playerContainer.className = 'player-box';
          playerContainer.innerHTML = "<span>Player Character Not Found... Please try again.</span>";
          $(playerContainer).insertAfter($('li#field_1_4'));
          $('.overlay').remove();
        }
      })
      .fail(function(response) {
        console.error(response);
      });
  }

  $name.blur(_.debounce(function() {
    var fname = $fName.val()
      , lname = $lName.val()
      , world = $world.val();

    if(fname.length > 0 && lname.length > 0 && world.length > 0) {
      searchPlayer(fname, lname, world);
    }
  }));

  $(document).on( 'keypress', '.gform_wrapper', function (e) {
    var code = e.keyCode || e.which;
    if ( code == 13 && ! jQuery( e.target ).is( 'textarea,input[type="submit"],input[type="button"]' ) ) {
        e.preventDefault();
        return false;
    }
  });
})(jQuery);