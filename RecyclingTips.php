<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Recycling Tips - GreenHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
       /* Header */
       .header {
        width: 100%;
        padding: 5px;
        background-color: #28a745;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        position: sticky;
        top: 0;
        z-index: 20; 
    }
    .logo-container {
        padding: 5px;
    }

    .logo-container img {
        width: 80px;
        height: auto;
        display: block;
    }


    .nav-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #fff;
    }

    .brand-name {
        font-size: 1.8em;
        letter-spacing: 2px;
        font-weight: bold;
        color: #a7ffeb;
    }

    .nav-section ul {
        list-style: none;
        display: flex;
        gap: 20px;
    }

    .nav-section ul li a {
        text-decoration: none;
        color: #a7ffeb;
        font-weight: bold;
        padding: 5px 8px;
        border-radius: 20px;
        transition: background-color 0.3s ease;
        font-size: 20px;
    }

    .nav-section ul li a:hover {
        background-color: #004d40;
        color: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
    }
        .container {
            max-width: 1000px;
            margin: 40px auto;
            background-color: #d5f3e0;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #28a745;
            font-size: 28px;
            margin-bottom: 15px;
        }
        .tips {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 30px;
        }
        .tip-card {
            flex-basis: 45%;
            margin: 20px 0;
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }
        .tip-card:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .tip-card h3 {
            color: #B0FC38;
            font-size: 26px;
            margin-bottom: 15px;
        }
        .tip-card p {
            font-size: 20px;
            line-height: 1.6;
            color: white;
        }
        .reuse-tips {
            max-width: 1000px;
            margin: 40px auto;
            background-color: #d5f3e0;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
}

.reuse-tips h3 {
    color: #28a745;
            font-size: 30px;
            margin-bottom: 15px; 
    text-align: center; 
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2); 
}

.reuse-tips ul {
    list-style-type: none; 
    padding: 0; 
}

.reuse-tips li {
    background-color: white; 
    border-radius: 8px; 
    margin: 10px 0;
    padding: 15px;
    transition: transform 0.2s, box-shadow 0.2s; 
}

.reuse-tips li:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); 
}

.reuse-tips li strong {
    color: #1e3a8a;
    font-size: 20px; 
}

.reuse-tips li:last-child {
    margin-bottom: 0; 
}
.reuse-videos {
    background-color: #d5f3e0;
    border-radius: 12px; 
    padding: 20px; 
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 
    font-family: 'Arial', sans-serif; 
    margin: 20px; 
}

.reuse-videos h3 {
    color: #28a745;
    font-size: 30px; 
    text-align: center; 
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2); 
}

.video-container {
    display: flex; 
    flex-wrap: wrap; 
    justify-content: center; 
    gap: 20px; 
    margin-top: 20px; 
}

.video-container iframe {
    width: 300px; 
    height: 170px; 
    border-radius: 8px; 
    transition: transform 0.2s; 
}

.video-container iframe:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); 
}


        .footer {
                background-color: #4CAF50;
                color: #fff;
                padding: 10px 0;
                font-size: 0.9rem;
            }

            .footer-container {
                display: flex;
                justify-content: space-around;
                flex-wrap: wrap;
                max-width: 1500px;
                margin: 0 auto;
            }

            .footer-section {
                flex-basis: 30%;
                margin-bottom: 10px;
            }

            .footer-section h3 {
                margin-bottom: 10px;
                font-size: 1.2rem;
                text-align: center;
            }

            .subscribe-form {
                display: flex;
                align-items: center;
            }

            .subscribe-form input[type="email"] {
                padding: 8px;
                width: 70%;
                border: none;
                border-radius: 5px 0 0 5px;
            }

            .subscribe-form button {
                padding: 8px;
                background-color: #00ffe5;
                border: none;
                color: #004d40;
                border-radius: 0 5px 5px 0;
                cursor: pointer;
            }

            .social-icons a {
                color: white;
                font-size: 20px;
                margin-right: 25px;
            }

            .social-icons ul {
                list-style-type: none;
                padding: 0;
                margin: 0;
                display: flex;
                justify-content: center;
            }

            .social-icons ul li {
                margin: 0 8px;
            }

            .social-icons ul li a {
                color: white;
                font-size: 20px;
                text-decoration: none;
            }

            .social-icons ul li a:hover {
                color: #80cbc4;
            }

            .footer-bottom {
                text-align: center;
                padding-top: 10px;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                font-size: 0.8rem;
            }
    </style>
</head>
<body>
<header class="header">
            <nav class="nav-section">
                <div class="brand-and-navBtn">
                    <div class="logo-container">
                        <img src="logo.jpeg" alt="Logo">
                    </div>
                </div>
                <div class="top-nav" id="topNav">
                    <ul>
                    <li><a href="home.php" class="active">Home</a></li>
                    <li><a href="location.php">Locations</a></li>
                    <li><a href="dashboard.php">Game DashBoard</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="index.php">Logout</a></li>
                    </ul>
                </div>
            </nav>
        </header>
    <!-- Main Container for Tips -->
    <div class="container">
        <h2>Learn the Best Practices for Recycling and Reducing Waste</h2>
        <p>Make the most of your recycling efforts by following these simple tips and doing your part for the environment.</p>

        <!-- Flexbox Layout for Recycling Tips -->
        <div class="tips">
            <!-- Tip Card 1 -->
            <div class="tip-card" style="background-image: url('tip2.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                <h3>Separate Materials Properly</h3>
                <p>Ensure that plastics, paper, metals, and glass are sorted properly. Mixing materials can contaminate recyclables and prevent proper processing.</p>
            </div>

            <!-- Tip Card 2 -->
            <div class="tip-card" style="background-image: url('tip6.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                <h3>Clean Your Recyclables</h3>
                <p>Rinse out containers before recycling. Removing food residue helps ensure the material can be recycled properly.</p>
            </div>

            <!-- Tip Card 3 -->
            <div class="tip-card" style="background-image: url('tip1.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                <h3>Know What Can Be Recycled</h3>
                <p>Not all plastics, papers, or metals are recyclable. Check local guidelines to see what your center accepts.</p>
            </div>

            <!-- Tip Card 4 -->
            <div class="tip-card" style="background-image: url('tip3.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                <h3>Avoid Plastic Bags</h3>
                <p>Don’t recycle plastic bags through curbside programs. Instead, bring them to special drop-off locations at stores or recycling centers.</p>
            </div>

            <!-- Tip Card 5 -->
            <div class="tip-card" style="background-image: url('tip4.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                <h3>Compost Organic Waste</h3>
                <p>Instead of throwing food waste in the trash, compost it to reduce landfill waste and create nutrient-rich soil for gardens.</p>
            </div>

            <!-- Tip Card 6 -->
            <div class="tip-card" style="background-image: url('tip5.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                <h3>Recycle Electronics Responsibly</h3>
                <p>Many electronics contain hazardous materials. Recycle them at designated e-waste recycling centers.</p>
            </div>
        </div>
    </div>

    <div class="reuse-tips">
            <h3>Tips for Reusing and Recycling at Home</h3>
            <ul>
                <li>
                    <strong>Use glass jars for storage:</strong> Instead of buying new containers, repurpose glass jars to store dry goods, spices, or craft supplies. They are durable, airtight, and can help reduce plastic waste. You can label the jars for easy identification, making it simple to organize your pantry or craft room.
                </li>
                <li>
                    <strong>Turn old t-shirts into reusable shopping bags:</strong> Cut and sew or tie old t-shirts to create eco-friendly bags for grocery shopping, reducing the need for single-use plastic bags. This project requires minimal sewing skills and can be a fun activity for the whole family. Plus, you can customize the bags with fabric paint or markers.
                </li>
                <li>
                    <strong>Repurpose cardboard boxes:</strong> Use them for organizing items in your home, such as toys, documents, or seasonal decorations. You can also decorate the boxes to match your decor using wrapping paper, fabric, or paint. This not only helps keep your space tidy but also gives a second life to materials that would otherwise be thrown away.
                </li>
                <li>
                    <strong>Create compost bins:</strong> Instead of throwing organic waste in the trash, compost kitchen scraps like fruit peels, vegetable leftovers, and coffee grounds to create nutrient-rich soil for your garden. Composting reduces greenhouse gas emissions from landfills and returns valuable nutrients to the soil. Start with a small bin and gradually expand as you learn what works best for your compost.
                </li>
                <li>
                    <strong>Use old newspapers for wrapping gifts:</strong> Instead of buying new wrapping paper, use old newspapers or magazines to wrap gifts. This adds a unique touch and is environmentally friendly. You can also get creative by using colorful pages or sections that match the occasion, making your gift wrapping a fun and artistic project.
                </li>
                <li>
                    <strong>Make DIY cleaning supplies:</strong> Use old spray bottles to mix vinegar and water for an all-purpose cleaner. Vinegar is a natural disinfectant and deodorizer, making it a safe alternative to harsh chemicals. You can also add essential oils like lemon or lavender for a pleasant scent. This practice reduces plastic waste and promotes a healthier home environment.
                </li>
                <li>
                    <strong>Upcycle furniture:</strong> Instead of discarding old furniture, consider painting or refinishing it to give it a new life. This not only saves money but also helps reduce landfill waste. Look for inspiration online for DIY furniture projects, such as reupholstering chairs or refinishing wooden tables. Your creativity can turn an old piece into a statement item in your home.
                </li>
                <li>
                    <strong>Use egg cartons for seed starters:</strong> Cut egg cartons in half and use them to start seedlings indoors. Once the plants grow, you can transplant them directly into the garden. The biodegradable nature of egg cartons means they can break down in the soil, providing nutrients to the plants. This is a great way to get kids involved in gardening and teach them about plant growth.
                </li>
                <li>
                    <strong>Donate items you no longer need:</strong> Instead of throwing away clothes, books, or household items, consider donating them to local charities or thrift stores. This helps others while keeping items out of landfills. Many organizations also offer pickup services for larger items, making it convenient to give back to the community.
                </li>
                <li>
                    <strong>Use glass containers for leftovers:</strong> Store food leftovers in glass containers instead of plastic ones. This reduces plastic use and keeps food fresh without harmful chemicals leaching into your food. Glass containers are microwave and dishwasher safe, making them easy to clean and reuse. Investing in a set of glass storage containers can also enhance your kitchen's aesthetics.
                </li>
            </ul>
        </div>

        <div class="reuse-videos">
    <h3>DIY Projects At The Comfort Of Your Home</h3>
    <div class="video-container">
    <iframe src="https://www.youtube.com/embed/Xs2hAWuPmSg?si=mGLH1e1CwRBstE3d" frameborder="0"  allowfullscreen></iframe>
        <iframe src="https://www.youtube.com/embed/eXYZ29-2-eg?si=_WLmYshTZTx-HQ3i" frameborder="0" allowfullscreen></iframe>
            <iframe src="https://www.youtube.com/embed/G6OsBBsEQQ4?si=guI6pVXVh5LqmMXz" frameborder="0" allowfullscreen></iframe>
            <iframe src="https://www.youtube.com/embed/lxBbJKS8gBw?si=YRyBut4YdJuxysBM" frameborder="0" allowfullscreen></iframe>
                <iframe src="https://www.youtube.com/embed/Fgbr3J_UAgY?si=__n3FBnc7Sxf0-a2" frameborder="0"allowfullscreen></iframe>
                    <iframe src="https://www.youtube.com/embed/ScnRj3TVjsY?si=vnNcq7M1zhF75hZN" frameborder="0"allowfullscreen></iframe>
                        <iframe src="https://www.youtube.com/embed/4tzZZWx57d0?si=tb1scmdnvT5O4jZs" frameborder="0" allowfullscreen></iframe>
                            <iframe src="https://www.youtube.com/embed/m4wLpoGJJ10?si=rqQztm3vvHrO90g1" frameborder="0" allowfullscreen></iframe>
         </div>
</div>


    <!-- Footer -->
    <footer class="footer">
            <div class="footer-container">
                <div class="footer-section">
                    <h3>Stay Connected</h3>
                    <form class="subscribe-form">
                        <input type="email" placeholder="Enter your email" required>
                        <button type="submit">Subscribe</button>
                    </form>
                </div>
                <div class="footer-section">
                <h3>Contact Us</h3>
                <p>Email: thegreenhubapp@gmail.com</p>
                <p>Phone: (123) 456-7890</p>
            </div>
                <div class="footer-section social-icons">
                    <h3>Follow Us</h3>
                    <ul>
                        <li><a href=" https://www.facebook.com/RecycleProUK" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="https://x.com/greeneryorg?s=21" target="_blank"><i class="fab fa-twitter"></i></a></li>
                        <li><a href=" https://www.instagram.com/recycle.green/" target="_blank"><i class="fab fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        <div class="footer-bottom">
            <p>&copy; THE GREEN APP. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
