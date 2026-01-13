let images = ['photo1.jpg', 'photo2.jpg', 'photo3.jpg'];
    let currentImageIndex = 0;
    let autoSlideInterval = null;
    let reviewsVisible = 3;

    function showImage(index) {
        const sliderImage = document.getElementById('slider-image');
        sliderImage.style.opacity = 0;
        setTimeout(() => {
            sliderImage.src = images[index];
            sliderImage.style.opacity = 1;
        }, 400);
    }

    function nextImage() {
        currentImageIndex = (currentImageIndex + 1) % images.length;
        showImage(currentImageIndex);
    }

    function prevImage() {
        currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
        showImage(currentImageIndex);
    }

    function showMoreReviews() {
        const reviews = document.querySelectorAll('.reviews ul li');
        reviewsVisible += 3;
        for (let i = 0; i < reviewsVisible && i < reviews.length; i++) {
            reviews[i].style.display = 'block';
        }
        if (reviewsVisible >= reviews.length) {
            document.querySelector('.show-more').style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const reviews = document.querySelectorAll('.reviews ul li');
        reviews.forEach((review, index) => {
            if (index >= reviewsVisible) {
                review.style.display = 'none';
            }
        });
        setInterval(nextImage, 5000);
    });