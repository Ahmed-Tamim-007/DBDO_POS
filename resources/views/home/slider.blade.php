<div id="homepageCarousel" class="carousel slide mt-4" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{asset('images/pet-1.jpg')}}" class="d-block w-100" alt="Slide 1" style="opacity: 0.8;">
            <div class="carousel-caption">
                <h5>Welcome to Our Shop</h5>
                <p>Find the best products here at reasonable price.</p>
                <a href="{{ url('shop') }}" class="btn btn-primary">Explore</a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{asset('images/pet-8.jpg')}}" class="d-block w-100" alt="Slide 2" style="opacity: 0.8;">
            <div class="carousel-caption">
                <h5>Online Delivery</h5>
                <p>Explore Our New Collection and order from home.</p>
                <a href="{{ url('mycart') }}" class="btn btn-primary">Shop Now</a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{asset('images/pet-10.jpg')}}" class="d-block w-100" alt="Slide 3" style="opacity: 0.8;">
            <div class="carousel-caption">
                <h5>Get In Touch</h5>
                <p>Don't miss out on our exclusive deals and discounts.</p>
                <a href="{{ url('contact') }}" class="btn btn-primary">Contact Us</a>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#homepageCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#homepageCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
