(function(){

  $(function(){

      $("#create-billboard-form").on("submit", function(e) {

        e.preventDefault();
        var postData = new FormData($(this)[0]);
        $.ajax({
          url: '/billboard',
          type: "POST",
          data: postData,
          datatype: 'json',
          processData: false,
          contentType: false,
          success: function(data) {

            var html = '';
            $.each(JSON.parse(data), function (key, value) {
              html
            });

            $('#billboard-list').html('');
            $('#exampleModal').modal('hide'); 


          },
          error: function(jqXHR, status, error) {
            console.log(status + ": " + error);
          }
        });

    });
     
    $("#save-billboard").on('click', function() {
        $("#create-billboard-form").submit();
    });

  });

})();
