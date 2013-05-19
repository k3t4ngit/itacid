
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Fun with 3D rollovers</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <style>
      * {
        margin: 0;
        padding: 0;
      }
      footer, section ,header {
        display: block;
      }
      html {
        height: 100%;
        font-size: 15px;
        font-family: helvetica, arial, sans-serif;
        background: #ccc;
        background: -moz-linear-gradient(#ccc, #333);
        background: -webkit-linear-gradient(#ccc, #333);
        background: -ms-linear-gradient(#ccc, #333);
        background: -o-linear-gradient(#ccc, #333);
        background: linear-gradient(#ccc, #333);
      }
      h1 {
        font-size: 32px;
        color: #333;
        margin-bottom: 15px;
      }
      header, footer{
        text-align: center;
        padding: 10px 0;
      }
      footer a {
        color: #000;
      }
      #container {
        border-radius: 5px;
        margin: 10px auto;
        width: 800px;
        padding:10px 0;
        background: #fff;
        overflow: auto;
        box-shadow: 4px 4px 10px #333;
      }
      section {
        float: left;
        width: 200px;
        padding-top: 60px;
        margin:0 30px;
        position:relative;
      }
      section h2 {
        top: 5px;
        color: #666;
        padding: 5px;
        font-weight:normal;
        position: absolute;
        font-size: 24px;
      }
      .logos {
        -webkit-perspective:  800px;
        -moz-perspective:     800px;
        -ms-perspective:      800px;
        -o-perspective:       800px;
        perspective:          800px;
      }
      .cube {
        display: block;
        position: relative;
        margin: 50px auto;
        height: 200px;
        width: 200px;
        -webkit-transform-style:  preserve-3d;
        -moz-transform-style:     preserve-3d;
        -o-transform-style:       preserve-3d;
        -ms-transform-style:      preserve-3d;
        transform-style:          preserve-3d;
        -webkit-transition:       1.5s linear;
        -moz-transition:          1.5s linear;
        -o-transition:            1.5s linear;
        -ms-transition:           1.5s linear;
        transition:               1.5s linear;
        -webkit-transform:        rotateY(0deg);
        -moz-transform:           rotateY(0deg);
        -ms-transform:            rotateY(0deg);
        -o-transform:             rotateY(0deg);
        transform:                rotateY(0deg);
      }
      .logos:hover .cube, .logos:focus .cube {
        -webkit-transform:  rotateY(360deg);
        -moz-transform:     rotateY(360deg);
        -ms-transform:      rotateY(360deg);
        -o-transform:       rotateY(360deg);
        transform:          rotateY(360deg);
      }
      .front {
        z-index:10;
      }
      .back {
        z-index:1;
      }
      .logos:hover .front, .logos:focus .front {
        z-index:1;
      }
      .logos:hover .back, .logos:focus .back {
        z-index:10;
      }
      .front {
        position: absolute;
        height: 200px;
        width: 200px;
        -webkit-transform:  translateZ(100px);
        -moz-transform:     translateZ(100px);
        -ms-transform:      translateZ(100px);
        -o-transform:       translateZ(100px);
        transform:          translateZ(100px);
      }
      .back {
        position: absolute;
        height: 200px;
        width: 200px;
        -webkit-transform:  rotateY(180deg) translateZ(100px);
        -moz-transform:     rotateY(180deg) translateZ(100px);
        -ms-transform:      rotateY(180deg) translateZ(100px);
        -o-transform:       rotateY(180deg) translateZ(100px);
        transform:          rotateY(180deg) translateZ(100px);
      }
      .onelogo .front, .onelogo .back {
        background: #fff;
        -moz-backface-visibility:     hidden;
        -webkit-backface-visibility:  hidden;
        -ms-backface-visibility:      hidden;
        -o-backface-visibility:       hidden;
        backface-visibility:          hidden;
      }

      .flat .front {
        background:#fff;
        position: absolute;
        height: 200px;
        width: 200px;
        -webkit-transform:            translateZ(0) scale(1.2,1.2);
        -moz-transform:               translateZ(0) scale(1.2,1.2);
        -ms-transform:                translateZ(0) scale(1.2,1.2);
        -o-transform:                 translateZ(0) scale(1.2,1.2);
        transform:                    translateZ(0) scale(1.2,1.2);
        -webkit-backface-visibility:  hidden;
        -moz-backface-visibility:     hidden;
        -ms-backface-visibility:      hidden;
        -o-backface-visibility:       hidden;
        backface-visibility:          hidden;
      }
      .flat .back {
        background:#fff;
        position: absolute;
        height: 200px;
        width: 200px;
        -webkit-transform:            translateZ(0) rotateY(180deg) scale(1.2,1.2);
        -moz-transform:               translateZ(0) rotateY(180deg) scale(1.2,1.2);
        -ms-transform:                translateZ(0) rotateY(180deg) scale(1.2,1.2);
        -o-transform:                 translateZ(0) rotateY(180deg) scale(1.2,1.2);
        transform:                    translateZ(0) rotateY(180deg) scale(1.2,1.2);
        -webkit-backface-visibility:  hidden;
        -moz-backface-visibility:     hidden;
        -ms-backface-visibility:      hidden;
        -o-backface-visibility:       hidden;
        backface-visibility:          hidden;
      }
    </style>
  </head>
  <body>
    <header>
      <h1>Fun with 3D rollovers</h1>
      <p>These are three examples of 3D rollovers in CSS3. On browsers that don't support them they should fall back to simple rollovers.</p>
    </header>
    <div id="container"><section><h2>Box rotate</h2>
        <div class="logos" tabindex="0">
          <a class="cube" href="https://developer.mozilla.org/en/HTML/HTML5">
            <img src="<?php echo base_url(); ?>_assets/img/mdnface.png"  class="front" alt="MDN">
            <img src="<?php echo base_url(); ?>_assets/img/htmlface.png" class="back" alt="HTML5">
          </a>
        </div>
      </section>
      <section><h2>Box rotate with hidden back logo</h2>
        <div class="logos onelogo" tabindex="0">
          <a class="cube" href="https://developer.mozilla.org/en/HTML/HTML5">
            <img src="<?php echo base_url(); ?>_assets/img/mdnface.png"  class="front" alt="MDN">
            <img src="<?php echo base_url(); ?>_assets/img/htmlface.png" class="back" alt="HTML5">
          </a>
        </div></section>
      <section><h2>Flat</h2>
        <div class="logos flat" tabindex="0">
          <a class="cube" href="https://developer.mozilla.org/en/HTML/HTML5">
            <img src="<?php echo base_url(); ?>_assets/img/mdnface.png"  class="front" alt="MDN">
            <img src="<?php echo base_url(); ?>_assets/img/htmlface.png" class="back" alt="HTML5">
          </a>
        </div></section></div>
    <footer>
      <a href="http://www.w3.org/html/logo/">
        <img src="http://www.w3.org/html/logo/badge/html5-badge-h-css3-graphics-semantics.png" width="197" height="64" alt="HTML5 Powered with CSS3 / Styling, Graphics, 3D &amp; Effects, and Semantics" title="HTML5 Powered with CSS3 / Styling, Graphics, 3D &amp; Effects, and Semantics">
      </a><p>Written by <a href="http://twitter.com/codepo8">Chris Heilmann (@codepo8)</a></p>
    </footer>
  </body>
</html>