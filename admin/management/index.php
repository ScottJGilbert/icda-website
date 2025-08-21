<?php
require_once __DIR__ . '/../middleware.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Management | ICDA</title>
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
        <p class="title">Edit Constitution</p>
        <div style="display: flex; gap: 8px;">
          <form id="newConstitution" style="transform: translateY(18px);">
            <label for="constitution"><input type="file" id="constitution" name="constitution" accept=".pdf"
                required /></label>
          </form>
          <button onclick="newConstitution()">Upload</button>
        </div>
      </section>
    </div>
    <div class="division">
      <section>
        <p class="title">New User</p>
        <div>
          <form id="new-user-form">
            <div style="display: flex; gap: 4px; flex-wrap: wrap;">
              <label for="name">
                <input id="name" name="name" type="text" required />
                Name <span style="color: red">*</span>
              </label>
              <label for="username">
                <input id="username" name="username" type="text" autocomplete="off" required />
                Username <span style="color: red">*</span>
              </label>
              <label for="password">
                <input id="password" name="password" type="password" autocomplete="new-password" required />
                Password <span style="color: red">*</span>
              </label>
              <label for="password">
                <input id="confirmPassword" type="password" autocomplete="new-password" required />
                Confirm Password <span style="color: red">*</span>
              </label>
            </div>

            <div style="display: flex; flex-direction: column;">
              <label for="editor">
                <input type="radio" id="editor" name="access_level" value="Editor" checked="true" />
                Editor (can edit non-post data and upload results/legislation,
                etc.)
              </label>
              <br />
              <label for="poster">
                <input type="radio" id="poster" name="access_level" value="Poster" />
                Poster (all editing permissions + creating/updating/deleting
                posts)
              </label>
              <br />
              <label for="administrator">
                <input type="radio" id="administrator" name="access_level" value="Administrator" />
                Administrator (all permissions)</label>
              <br />
            </div>
          </form>
          <button onclick="newUser()">Add User</button>
        </div>
      </section>
    </div>
    <div class="division">
      <section>
        <p class="title">Manage Site Users</p>
        <div id="currentUsers">
          <p style="font-family: Arial, monospace;">
            <i>Note: for security reasons, user information cannot be edited directly. If you
              need to edit a user's information, please delete their current user and
              create a new one for them.
            </i>
          </p>
        </div>
      </section>
    </div>
    <div class="division">
      <section>
        <p class="title">Manage Active Sessions</p>
        <p style="font-family: Arial, monospace;">
          <i>Note: expired user sessions are cleared every five minutes.</i>
        <div id="currentSessions"></div>
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