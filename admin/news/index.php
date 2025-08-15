<?php
require_once 'middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>News | ICDA</title>
    <link rel="icon" href="/public/images/favicon.png" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="/public/global.css" />
    <script src="/public/global.js"></script>
    <script src="script.js"></script>

    <script
      src="https://unpkg.com/react@18/umd/react.development.js"
      crossorigin
    ></script>
    <script
      src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"
      crossorigin
    ></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
  </head>

  <body>
    <div id="mobile-menu-root"></div>
    <div id="top"></div>

    <!-- Everything below is actual page content and varies by file -->

    <h1 id="title">News</h1>
    <div id="list"></div>

    <div>
      <button id="pageDown" onclick="pageDown()">←</button>
      <button id="pageUp" onclick="pageUp()">→</button>
    </div>

    <!-- Everything above is actual page content and varies by file -->

    <footer id="footer"></footer>

    <!-- React components (Babel-in-browser) -->
    <script type="text/babel" src="/public/components/mobile-menu.jsx"></script>
    <script type="text/babel" src="/public/components/header.jsx"></script>
    <script type="text/babel" src="/public/components/footer.jsx"></script>

    <!-- React entry point -->
    <script type="text/babel">
      const mobileRoot = ReactDOM.createRoot(
        document.getElementById("mobile-menu-root")
      );
      mobileRoot.render(<MobileMenu />);

      const headerRoot = ReactDOM.createRoot(document.getElementById("top"));
      headerRoot.render(<TopHeader />);

      const footerRoot = ReactDOM.createRoot(document.getElementById("footer"));
      footerRoot.render(<Footer />);

      function waitForReactAndInitialize() {
        const maxAttempts = 50;
        let attempts = 0;

        const interval = setInterval(() => {
          const headerLinks = document.getElementsByClassName("link");
          const headerMenus = document.getElementById("headerMenus");

          if (headerLinks.length > 0 && headerMenus) {
            clearInterval(interval);
            initialize();
          }

          attempts++;
          if (attempts > maxAttempts) {
            clearInterval(interval);
            console.warn(
              "initialize() timed out waiting for React components."
            );
          }
        }, 100); // check every 100ms
      }

      waitForReactAndInitialize();
    </script>
  </body>
</html>
