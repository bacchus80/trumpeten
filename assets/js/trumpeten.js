var editTypes = {
    edit: 'Ändra',
    create : 'Skapa'
};

var types = {
  'note': 'notis',
  'event': 'händelse',
  'news': 'nyhet',
  'user': 'användare',
  'booking': 'bookning'
};


function getType(type) {
  var quoted = "\""+type+"\"";
  return types[eval(quoted)];
}


function getEditType(type) {
  var quoted = "\""+type+"\"";
  return editTypes[eval(quoted)];
}


function styleSubmitButton(action) {
  if(action == 'delete') {
      $("#modal-button").html("Radera");
      $("#modal-button").removeClass("btn-primary");
      $("#modal-button").addClass("btn-danger");
  } else if(action == 'save') {
      $("#modal-button").html("Spara");
      $("#modal-button").addClass("btn-primary");
      $("#modal-button").removeClass("btn-danger");
  }
}


function getNotes() {
  console.log(window.location);
    $.ajax({
        url: '/Js/getnotes',
        dataType: 'json',
        success: function (result) {
          

//             setTimeout(function () {
//              $("#notes").append("<div>iaeia</div>");
//                }, 400);
                
          for(var i = 0; i < result.size; i++)
          {
            
//             setTimeout(function () {
//              $("#notes").append("<div>iaeia</div>");
//                }, 400);
//              $("#notes").wait(1000, function(index) {
//                    alert('whatever you like: ' + this.text());
                if(getCookie(result.ids[i]) == null) {
                $("#notes").append(result.data[i]).hide().fadeIn(400);
              }
//              });​
//             setTimeout(function () {
//              $("#notes").append(result.data[i]).hide().fadeIn(500);
//                }, 100);
          }
        },
        error: function () {
          console.log("error");
        }
    });
}


function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}


function myclose(i) {
  setCookie(i, 1, 1);
}


function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}


function eraseCookie(name) {   
    document.cookie = name+'=; Max-Age=-99999999;';  
}


$(function() {
    $("#web-booking").click(function(){
        window.location ="/blahuset/boka";
        
        $("#modal-button").html("Skicka");
        var url = '/shared/webbooking';
        var action = '/shared/webbooking';
        $.ajax({
            url: url,
            dataType: 'html',
            success: function (result) {
                $("#exampleModalLabel").html("Gör en preliminär bokning");
                $("#modalBody").html(result);
                $("#modal-form").attr("action", action);
                $("#exampleModal").modal();
            },
            error: function () {
                console.log("error");
            }
          });
    });
    

    $("#modal-button-pub").click(function(){
        //todo?
    });  
    $("#ga-group").hide();
    $('.dropdown-toggle').dropdown();

    $('.dropdown-toggle').dropdown()
    $(".js-list-group-link").click(function(){
        window.location = $(this).attr("data-url");
    });

    getNotes();

    $(document).on("change", "#user-role", function() {
      if($("#user-role").val() == 2) {
            $("#ga-group").show(500);
      } else {
            $("#ga-group").hide(500);
            $("#ga-group").val(0);
      }
    });


    $("#modal-button").click(function(){
       $("#modal-form").submit();
    });
    

    $(".j-dashboard-button").click(function(){
        var type = $(this).attr("data-type");
        styleSubmitButton("save");
        fetchModal("modal", type, "save", 0);
        $("#exampleModalLabel").html("Skapa "+getType(type));
        $("#exampleModal").modal();
    });


    $(".j-dropdown-crud").click(function(){
        var id = $(this).parent().attr("data-id");
        var type = $(this).parent().attr("data-type");
        var childType = $(this).attr("data-type");
        var method = "modal";
        var dbType = "save";
        if(childType == "delete") {
            dbType = "delete";
        //      $("#modal-form").attr("action", "/shared/delete/"+type+"/"+id);
            method = "question";
            styleSubmitButton("delete");
            $("#exampleModalLabel").html("Ta bort "+getType(type));
        } else {
            styleSubmitButton("save");
            $("#exampleModalLabel").html("Ändra "+getType(type));
        }
        fetchModal(method, type, dbType, id);
        $("#exampleModal").modal();
    })
});


// save, delete
function fetchModal(method, type, dbType, id=0) {
    var url = '/shared/'+method+'/'+type+'/'+id;
    var action = '/shared/'+dbType+'/'+type+'/'+id;
    $.ajax({
        url: url,
        dataType: 'html',
        success: function (result) {
            $("#modalBody").html(result);
            $("#modal-form").attr("action", action);
        },
        error: function () {
            console.log("error");
        }
    });
}


function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#upload-img')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}