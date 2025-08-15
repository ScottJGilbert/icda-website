<?php
require_once __DIR__ . '/../middleware.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Edit Resources | ICDA</title>
  <link rel="icon" href="/public/images/favicon.png" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="/public/global.css" />
  <script src="/public/global.js"></script>
  <script src="script.js"></script>

  <script src="https://unpkg.com/react@18/umd/react.development.js" crossorigin></script>
  <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js" crossorigin></script>
  <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
</head>

<body>
  <div id="mobile-menu-root"></div>
  <div id="top"></div>

  <!-- Everything below is actual page content and varies by file -->
  <div id="mainContent">
    <div class="division">
      <section>
        <h1 class="title">Edit Resources</h1>
      </section>
    </div>

    <div class="division">
      <section>
        <p class="title">New Rule</p>
        <div>
          <form id="add-rule" style="display: flex; flex-direction: column; gap: 4px;">
            <div>
              <label for="name">
                <input type="text" id="name" name="name" placeholder="Gaveling Procedure" required />
                Rule Name <span style="color: red">*</span>
              </label>
              <label for="number"> <input type="number" id="number" name="number" required />
                Rule Number <span style="color: red">*</span>
              </label>
            </div>
            <div style="display: flex; flex-direction: column; gap: 2px; margin-top: 4px;">
              <label for="summary">Rule Summary <span style="color: red">*</span>
                <textarea id="summary" name="summary" spellcheck="default" required></textarea>
              </label>
            </div>
          </form>
          <button onclick="addRule()">Add Rule</button>
        </div>

      </section>
    </div>

    <div class="division">
      <section>
        <p class="title">Update Rules</p>
        <button onclick="updateRules()" style="background-color: darkgreen;">
          <h1>Save Rules</h1>
        </button>
        <div id="rules"></div>
      </section>
    </div>
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