<?php
require_once __DIR__ . '/../middleware.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Edit About | ICDA</title>
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
        <p class="title">Edit About</h1>
      </section>
    </div>
    <div class="division">
      <section
        style="background-color: #e2f2ff; border: #242557 4px solid; display: flex; flex-direction: column; gap: 2px;">
        <div>
          <p class="title">Edit Schools</h2>
          <div id="schools"></div>
        </div>
        <div style="display: flex; flex-direction: column; gap: 4px;">
          <p class="title">New School Form</p>
          <form id="new-school-form">
            <label for="name">
              <input type="text" id="name" name="name" placeholder="Name" required />
              Name <span style="color: red">*</span>
            </label>
            <label for="image">
              <input type="file" id="image" name="image" accept="image/*" />
              Logo
            </label>
          </form>
          <div>
            <button onclick="addNewSchool()">Add School</button>
          </div>
        </div>
      </section>
    </div>
    <div class="division">
      <section style="background-color: #e2f2ff; border: #242557 4px solid;">
        <p class="title">Edit Oversight</p>
        <div id="oversight"></div>
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