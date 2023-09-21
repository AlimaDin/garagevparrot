document.addEventListener("DOMContentLoaded", function() {
    const reviewForm = document.getElementById("reviewForm");
    const reviewList = document.getElementById("reviewList");

    reviewForm.addEventListener("submit", function(e) {
        e.preventDefault(); // Prevent the form from refreshing the page

        const name = e.target.querySelector('input[type="text"]').value;
        const review = e.target.querySelector('textarea').value;

        if (name && review) {
            const li = document.createElement("li");
            li.classList.add("review");

            const h5 = document.createElement("h5");
            h5.textContent = name;
            li.appendChild(h5);

            const p = document.createElement("p");
            p.textContent = review;
            li.appendChild(p);

            reviewList.appendChild(li);

            // Optionally reset the form fields after adding the review
            e.target.reset();
        }
    });
});
