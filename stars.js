 // Select all elements with the "i" tag and store them in a NodeList called "stars"
 const stars = document.querySelectorAll(".stars i");
 // Loop through the "stars" NodeList
 stars.forEach((star, index1) => {
   // Add an event listener that runs a function when the "click" event is triggered
   star.addEventListener("click", () => {
     // Loop through the "stars" NodeList Again
     stars.forEach((star, index2) => {
       // Add the "active" class to the clicked star and any stars with a lower index
       // and remove the "active" class from any stars with a higher index
       index1 >= index2 ? star.classList.add("active") : star.classList.remove("active");
     });
   });
 });

let currentRating = 0;

function setRating(rating) {
    currentRating = rating;

    document.getElementById('rating').value = rating;

    const stars = document.querySelectorAll('.fa-star');
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.add('checked');
        } else {
            star.classList.remove('checked');
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('.fa-star');
    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            setRating(index + 1);
        });
    });
});
