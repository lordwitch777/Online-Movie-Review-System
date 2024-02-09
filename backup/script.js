document.addEventListener("DOMContentLoaded", function() {
    const generateButton = document.getElementById("generate-button");
    const movieTitle = document.getElementById("movie-title");
    const movieImage = document.getElementById("movie-image");

    generateButton.addEventListener("click", function() {
        fetch("randomgen.php")
            .then(response => response.json())
            .then(data => {
                movieTitle.textContent = data.movie_name;
                movieImage.src = data.movie_img;
            });
    });
});
