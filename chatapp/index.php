
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connectify</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap"
      rel="stylesheet"
    />
  </head>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
  </style>
  <style>
    body {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    html,
    body {
      height: 100%;
    }

    header {
      position: sticky;
      top: 0;
      z-index: 1000;
      background-color: rgba(253, 253, 253, 0.836);
    }

    .navbar nav {
      display: flex;
      justify-content: space-around;
      padding: 5px;
      background-color: rgba(253, 253, 253, 0.836);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .navbar ul li a:hover {
      font-weight: 600;
    }

    .navbar ul li a {
      text-decoration: none;
      font-family: poppins;
      color: black;
    }
    .navbar ul {
      list-style: none;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 20px;
    }
    .loginbutton {
      padding: 10px;
    }
    .loginbutton button:hover {
      background-color: rgba(69, 71, 74, 0.116);
      border-radius: 20px;
    }
    .loginbutton button {
      font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI",
        Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue",
        sans-serif;
      padding: 5px 40px;
      font-size: 16px;
      border: none;
      background-color: rgb(255, 255, 255);
    }
    .loginbutton a {
      text-decoration: none;
      color: black;
      font-size: 18px;
      font-weight: 500;
      padding: 10px 25px;
    }

    /* Container main */

    .container {
      display: flex;
      justify-content: space-evenly;
      padding-left: 50px;
      padding-right: 50px;
      padding-bottom: 100px;
    }
    .container_headings {
      font-size: 25px;
      font-family: poppins;
    }
    .highlight {
      background-color: rgba(30, 30, 25, 0.203);
    }
    .containerimg {
      padding-top: 30px;
      padding-left: 130px;
      filter: brightness(100%);
    }
    .getstartedbutton button {
      font-family: poppins;
      color: whitesmoke;
      background-color: rgba(0, 0, 0, 0.92);
      border-radius: 7px;
      padding: 10px 30px;
      font-size: 16px;
      font-weight: 500;
      position: absolute;
      z-index: 1000;
    }
    .getstartedbutton button:hover {
      background-color: rgba(0, 0, 0, 0.858);
    }
    .getstartedbutton a {
      text-decoration: none;
      color: aliceblue;
      padding: 10px 30px;
    }

    /* footer */

    .background {
      position: absolute;
      z-index: -1;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
    }

    ul {
      display: flex;
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .socials {
      gap: 20px;
      color: rgba(255, 255, 255, 0.749);
      display:flex;
      justify-content:center;
    }

    .socials a {
      font-size: 24px;
    }

    .links {
      gap: 10px;
      color: aliceblue;
    }

    .legal {
      font-size: 12px;
      margin: 0;
      color: aliceblue;
      text-align:center;
    }

    svg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      transform: scaleY(3) scaleX(2.25);
      transform-origin: bottom;
      box-sizing: border-box;
      display: block;
      pointer-events: none;
      margin: 100px;
    }

    footer {
      position: fixed;
      left: 0;
      bottom: 0;
      display: flex;
      width: 100%;
      height: 370px;
      /* z-index: -1; */
    }

    section {
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      gap: 30px;
      padding-bottom: 80px;
      padding-left: 60px;
      width: 100%;
      margin-top: 350px;
    }

   
  </style>
  <body>
    <header>
      <div class="navbar">
        <nav>
          <div class="logoimg">
              <a href="Landingpage.php"><img src="./images/logo2.png" alt="" height="50px" /></a>
          </div>
          <ul>
            <li>
              <a href="Landingpage.html">Home</a>
            </li>
            <li>
              <a href="offerings.html">Offerings</a>
            </li>
            <li>
              <a href="http://">About Us</a>
            </li>
            <li>
              <a href="http://">Our Team</a>
            </li>
            <li>
              <a href="http://">Contact</a>
            </li>
          </ul>
          <div class="loginbutton">
            <button>
             <a href="login.php">Login</a>  
            </button>
          </div>
        </nav>
      </div>
    </header>
    <main>
      <div class="container">
        <div class="container_headings">
          <h1>Unleash the Power of Unified Communication.</h1>
          <p>
            Connect with your team like never before with our
            <span class="highlight">all-in-one solution.</span>
          </p>
          <div class="getstartedbutton">
            <button >
             <a href="signup.php">Signup</a>
            </button>
          </div>
        </div>
        <div class="containerimg">
          <img src="landingsideimgfinal.png" alt="" height="350px" />
        </div>
      </div>
    </main>
    <footer>
      <div class="background">
        <svg
          version="1.1"
          xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink"
          x="0px"
          y="0px"
          width="100%"
          height="100%"
          viewBox="0 0 1600 900"
        >
          <defs>
            <path
              id="wave"
              fill="rgba(0, 0, 0, 0.60)"
              d="M-363.852,502.589c0,0,236.988-41.997,505.475,0
        s371.981,38.998,575.971,0s293.985-39.278,505.474,5.859s493.475,48.368,716.963-4.995v560.106H-363.852V502.589z"
            />
          </defs>
          <g>
            <use xlink:href="#wave" opacity=".4">
              <animateTransform
                attributeName="transform"
                attributeType="XML"
                type="translate"
                dur="8s"
                calcMode="spline"
                values="270 230; -334 180; 270 230"
                keyTimes="0; .5; 1"
                keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0"
                repeatCount="indefinite"
              />
            </use>
            <use xlink:href="#wave" opacity=".6">
              <animateTransform
                attributeName="transform"
                attributeType="XML"
                type="translate"
                dur="6s"
                calcMode="spline"
                values="-270 230;243 220;-270 230"
                keyTimes="0; .6; 1"
                keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0"
                repeatCount="indefinite"
              />
            </use>
            <use xlink:href="#wave" opacty=".9">
              <animateTransform
                attributeName="transform"
                attributeType="XML"
                type="translate"
                dur="4s"
                calcMode="spline"
                values="0 230;-140 200;0 230"
                keyTimes="0; .4; 1"
                keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0"
                repeatCount="indefinite"
              />
            </use>
          </g>
        </svg>
      </div>

      <section>
        <ul class="socials">
          <li>
            <a href="https://www.google.co.in/"
              ><img src="./images/instagram.png" alt="" srcset="" height="25px"
            /></a>
          </li>
          <li>
            <a href=""
              ><img src="./images/twitter.png" alt="" srcset="" height="25px"
            /></a>
          </li>
          <li>
            <a href=""
              ><img src="./images/facebook.png" alt="" srcset="" height="25px"
            /></a>
          </li>
        </ul>
        <p class="legal">© 2024 All rights reserved</p>
      </section>
    </footer>
  </body>
</html>
