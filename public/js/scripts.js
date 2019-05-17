$(document).ready(function() {

      // Ajax Get Projects
/*       $.ajax({
        method: 'GET',
        url: 'http://localhost/rest-it/public/api/overview',
        datatype: 'json',
        success: function(data) {
          console.log(data);

        }
      }); */

      // Ajax Get Single Project
/*       $.ajax({
        method: 'GET',
        url: 'http://localhost/rest-it/public/api/project/2',
        datatype: 'json',
        success: function(data) {
          console.log(data);

        }
      }); */


      // Initialisize Project
      var project = {
        "init_date" : "2018-08-14 17:08:25",
        "title" : "asdfg",
        "description" : "asdfg",
        "img_url" : "sadfghj",
        "organisation_id" : "1",
        "brand_id" : "1",
        "product_id" : "1"
      };


      // Create Project
/*       $.ajax({
        method: 'POST',
        url: 'http://localhost/rest-it/public/api/create-project',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: project,
        datatype: 'json',
        success: function(data) {
            console.log(data)
        }
      }); */

/*       $.ajax({
        method: 'GET',
        url: 'http://localhost/rest-it/public/api/comment/1',
        datatype: 'json',
        success: function(data) {
          console.log(data);
        }
      }); */
/*
        $.ajax({
        method: 'POST',
        url: 'http://localhost/rest-it/public/api/create-comment',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          "comment" : "test_kommentar",
          "project_id" : "1"
      },
        datatype: 'json',
        success: function(data) {
            console.log(data)
        }
      });
 */

});
