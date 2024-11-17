<?php
// login.php
session_start();
require_once 'includes/config.php';

// If user is already logged in, redirect to index.php
if (isset($_SESSION['email'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags and title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No-Nonsense Helpdesk App</title>

    <!-- Bootstrap CSS for grid and icons -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
            <!-- Light mode favicon -->
    <link rel="icon" type="image/svg+xml" href="favicon.svg" media="(prefers-color-scheme: light)">
    
    <!-- Dark mode favicon -->
    <link rel="icon" type="image/svg+xml" href="favicon-dark.svg" media="(prefers-color-scheme: dark)">
    
</head>
<body>

    <!-- Header Section -->
    <header class="header fixed-top">
        <nav class="navbar navbar-expand-lg" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="#">
                <!-- Using the provided SVG as the logo -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="40">
                    <path d="M256 48C141.1 48 48 141.1 48 256l0 40c0 13.3-10.7 24-24 24s-24-10.7-24-24l0-40C0 114.6 114.6 0 256 0S512 114.6 512 256l0 144.1c0 48.6-39.4 88-88.1 88L313.6 488c-8.3 14.3-23.8 24-41.6 24l-32 0c-26.5 0-48-21.5-48-48s21.5-48 48-48l32 0c17.8 0 33.3 9.7 41.6 24l110.4 .1c22.1 0 40-17.9 40-40L464 256c0-114.9-93.1-208-208-208zM144 208l16 0c17.7 0 32 14.3 32 32l0 112c0 17.7-14.3 32-32 32l-16 0c-35.3 0-64-28.7-64-64l0-48c0-35.3 28.7-64 64-64zm224 0c35.3 0 64 28.7 64 64l0 48c0 35.3-28.7 64-64 64l-16 0c-17.7 0-32-14.3-32-32l0-112c0-17.7 14.3-32 32-32l16 0z"/>
                </svg>
                <span class="ml-2">N/NAI Desk</span>
            </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                    <span class="navbar-toggler-icon"><i class="bi bi-list"></i></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                        <li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>
                        <li class="nav-item"><a class="nav-link" href="#testimonials">Testimonials</a></li>
                        <li class="nav-item"><a class="nav-link" href="#faq">FAQs</a></li>
                        
                        <li class="nav-item">
                            <a class="btn btn-secondary nav-link " href="auth.php">Log In</a>
                            </li>
                        <li class="nav-item">
                            <a href="#signup" class="btn btn-primary nav-link text-white">Sign Up</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1>Effortless Helpdesk for Small Businesses</h1>
                    <p>Ready to Go. Built for Your Needs. Powered by AI.</p>
                    <a href="#signup" class="btn btn-primary">Sign Up for Free</a>
                </div>
                <div class="col-md-6">
                    <!-- Placeholder for Hero Image -->
                    <img src="hero-img.svg" alt="Helpdesk Illustration" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Highlights Section -->
    <section id="features" class="features py-5">
        <div class="container">
            <h2 class="text-center mb-5">Feature Highlights</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="feature-item p-4 text-center box">
                        <i class="bi bi-ticket-perforated icon mb-3"></i>
                        <h3>Ticket Management</h3>
                        <p>Organize and manage all your customer queries in one place with an intuitive, easy-to-use interface.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-item p-4 text-center box">
                        <i class="bi bi-robot icon mb-3"></i>
                        <h3>Automated Responses</h3>
                        <p>Leverage AI to provide real-time, personalized responses that adapt, no canned replies, just intelligent support.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-item p-4 text-center box">
                        <i class="bi bi-chat-dots icon mb-3"></i>
                        <h3>Multi-Channel Support</h3>
                        <p>Handle customer interactions from email, chat, and social media seamlessly, all within one platform.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Unique Selling Points (USP) Section -->
    <section id="usp" class="usp py-5">
        <div class="container">
            <h2 class="text-center mb-4">No-Nonsense Helpdesk for Small Businesses</h2>
            <p class="text-center mb-5">Get started quickly with zero configurations. Our app is designed with small businesses in mind, integrating best practices for customer support right out of the box.</p>
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="usp-item p-3 text-center box">
                        <i class="bi bi-arrow-repeat icon mb-2"></i>
                        <h3>Intelligent Ticket Routing</h3>
                        <p>Automatically route tickets to the right team based on priority and context.</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="usp-item p-3 text-center box">
                        <i class="bi bi-lightbulb icon mb-2"></i>
                        <h3>Predictive Issue Resolution</h3>
                        <p>Resolve issues before they escalate with AI-driven insights.</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="usp-item p-3 text-center box">
                        <i class="bi bi-emoji-smile icon mb-2"></i>
                        <h3>Sentiment Analysis</h3>
                        <p>Understand customer emotions and respond accordingly for a more personalized experience.</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="usp-item p-3 text-center box">
                        <i class="bi bi-journal-text icon mb-2"></i>
                        <h3>Dynamic Knowledge Base</h3>
                        <p>Access an ever-evolving, personalized knowledge base tailored to your business needs.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="how-it-works py-5">
        <div class="container">
            <h2 class="text-center mb-5">How It Works</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="step p-4 text-center box">
                        <i class="bi bi-person-plus icon mb-2"></i>
                        <h3>Sign Up</h3>
                        <p>Create your account in just a few clicks using Google or Microsoft login options.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="step p-4 text-center box">
                        <i class="bi bi-play-circle icon mb-2"></i>
                        <h3>Start Using</h3>
                        <p>Immediately access a robust helpdesk system with built-in best practices—no setup required.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="step p-4 text-center box">
                        <i class="bi bi-graph-up icon mb-2"></i>
                        <h3>See Results</h3>
                        <p>Experience enhanced support efficiency with AI-powered tools and actionable insights.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials py-5">
        <div class="container">
            <h2 class="text-center mb-5">What Our Customers Say</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="testimonial-item p-4 text-center box">
                        <p>“This app transformed our customer support. It’s incredibly easy to use, and the AI features are game-changers!”</p>
                        <h4>John Doe</h4>
                        <p class="text-muted">CEO of SmallBiz Co.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="testimonial-item p-4 text-center box">
                        <p>“We were up and running in minutes. The automated responses save us so much time!”</p>
                        <h4>Jane Smith</h4>
                        <p class="text-muted">Founder of StartUp X</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="testimonial-item p-4 text-center box">
                        <p>“Finally, a helpdesk that understands small businesses. Highly recommend!”</p>
                        <h4>Raj Patel</h4>
                        <p class="text-muted">Manager at RetailHub</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="pricing py-5">
        <div class="container">
            <h2 class="text-center mb-5">Choose Your Plan</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="pricing-item p-4 text-center box">
                        <h3>Free Plan</h3>
                        <p>Manage up to 50 tickets per month with essential features.</p>
                        <p class="price">$0/month</p>
                        <a href="#signup" class="btn btn-primary">Choose Plan</a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="pricing-item p-4 text-center box">
                        <h3>Standard Plan</h3>
                        <p>Unlimited tickets, advanced reporting, and more.</p>
                        <p class="price">$29/month</p>
                        <a href="#signup" class="btn btn-primary">Choose Plan</a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="pricing-item p-4 text-center box">
                        <h3>Premium Plan</h3>
                        <p>For businesses needing AI-driven insights and advanced support features.</p>
                        <p class="price">$59/month</p>
                        <a href="#signup" class="btn btn-primary">Choose Plan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="faq py-5">
        <div class="container">
            <h2 class="text-center mb-5">Frequently Asked Questions</h2>
            <div class="accordion" id="faqAccordion">
                <div class="card box mb-3">
                    <div class="card-header" id="faqOne">
                        <h3 class="mb-0">
                            <button class="btn btn-link text-left" type="button" data-toggle="collapse" data-target="#collapseOne">
                                How much time does it take to get started?
                            </button>
                        </h3>
                    </div>
                    <div id="collapseOne" class="collapse show" data-parent="#faqAccordion">
                        <div class="card-body">
                            You can get started in less than 5 minutes. Just sign up, and you’re good to go!
                        </div>
                    </div>
                </div>
                <div class="card box mb-3">
                    <div class="card-header" id="faqTwo">
                        <h3 class="mb-0">
                            <button class="btn btn-link text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo">
                                Is there a free plan available?
                            </button>
                        </h3>
                    </div>
                    <div id="collapseTwo" class="collapse" data-parent="#faqAccordion">
                        <div class="card-body">
                            Yes, our Free Plan lets you manage up to 50 tickets per month with essential features.
                        </div>
                    </div>
                </div>
                <div class="card box mb-3">
                    <div class="card-header" id="faqThree">
                        <h3 class="mb-0">
                            <button class="btn btn-link text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree">
                                What makes this helpdesk different from others?
                            </button>
                        </h3>
                    </div>
                    <div id="collapseThree" class="collapse" data-parent="#faqAccordion">
                        <div class="card-body">
                            We built this app with small businesses in mind. It’s easy to use, requires no customization, and includes advanced AI features to streamline your support process.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer py-4">
        <div class="container text-center">
            <div class="footer-links mb-3">
                <a href="#home">Home</a> |
                <a href="#features">Features</a> |
                <a href="#pricing">Pricing</a> |
                <a href="#faq">FAQs</a> |
                <a href="#contact">Contact Us</a>
            </div>
            <div class="footer-social mb-3">
                <a href="#"><i class="bi bi-linkedin"></i></a>
                <a href="#"><i class="bi bi-twitter"></i></a>
                <a href="#"><i class="bi bi-facebook"></i></a>
            </div>
            <div class="footer-legal">
                <a href="#privacy">Privacy Policy</a> |
                <a href="#terms">Terms of Service</a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies (for collapse and navbar) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const MS_CLIENT_ID = '<?php echo MS_CLIENT_ID; ?>';
        const MS_TENANT_ID = '<?php echo MS_TENANT_ID; ?>';
        const MS_REDIRECT_URI = '<?php echo MS_REDIRECT_URI; ?>';
    </script>
    <script src="https://alcdn.msauth.net/browser/2.30.0/js/msal-browser.min.js"></script>
    <script src="/assets/auth.js"></script>
<!--/* Scroll Event Script */-->
<script>
    document.addEventListener('scroll', function () {
        var header = document.getElementById('mainNav');
        var svg = document.querySelector('.navbar-brand svg');
        var brandText = document.querySelector('.navbar-brand span');

        if (window.scrollY > 50) {
            header.classList.add('scrolled');
            svg.style.fill = '#FFFFFF'; // Change SVG color to white
            brandText.style.color = '#FFFFFF'; // Change text color to white
        } else {
            header.classList.remove('scrolled');
            svg.style.fill = '#0D652D'; // Revert SVG color to original green
            brandText.style.color = '#0D652D'; // Revert text color to original green
        }
    });
</script>

</body>
</html>
