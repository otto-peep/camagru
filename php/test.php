    <!DOCTYPE html>
    <html>
    <head>
      <script src="http://code.jquery.com/jquery-latest.min.js"></script>
      <script src="http://ajax.microsoft.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js"></script>
    </head>
    <body>

    <button id="cartoonsBtn">Cartoons</button>
    <button id="dramaBtn">Drama</button>

    <ul id="movieList"></ul>

    <script>
    var markup = "<li><b>${Name}</b> (${ReleaseYear})</li>";

    /* Compile the markup as a named template */
    $.template( "movieTemplate", markup );

    function getMovies( genre, skip, top ) {
      $.ajax({
        dataType: "jsonp",
        url: "http://odata.netflix.com/Catalog/Genres('" + genre
        + "')/Titles?$format=json&$skip="
        + skip + "&$top=" + top,
        jsonp: "$callback",
        success: function( data ) {
          /* Get the movies array from the data */
          var movies = data.d;

          /* Remove current set of movie template items */
          $( "#movieList" ).empty();

          /* Render the template items for each movie
          and insert the template items into the "movieList" */
          $.tmpl( "movieTemplate", movies )
          .appendTo( "#movieList" );
        }
      });
    }

    $( "#cartoonsBtn" ).click( function() {
      getMovies( "Cartoons", 0, 6 );
    });

    $( "#dramaBtn" ).click( function() {
      getMovies( "Drama", 0, 6 );
    });

    </script>

    </body>
    </html>