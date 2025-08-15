<?php
// require_once __DIR__ . '/../../middleware.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>New Post | ICDA</title>
  <link rel="icon" href="/public/images/favicon.png" />
  <link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" />
  <script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>
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
    <div class="divison">
      <section>
        <p class="title">New Post</p>
        <form name="newPost" id="newPost">
          <label for="title">
            <input type="text" id="title" name="title" placeholder="Title" required />
            Title <span style="color: red">*</span>
          </label>
          <input type="hidden" name="MAX_FILE_SIZE" value="8000000" />
          <label for="image">
            <input type="file" id="image" name="image" />
            Upload Image (Max 16MB)
          </label>
          <div style="margin-top: 10px;">
            <div id="editor"></div>
          </div>
        </form>
        <button onclick="save()">Save Changes</button>
      </section>
    </div>


    <script src="post-script.js"></script>

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