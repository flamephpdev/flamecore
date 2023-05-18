<style>
     @import url('https://fonts.googleapis.com/css2?family=Fira+Code:wght@500&display=swap');

     .data-code {
          font-size: 18px;
          padding: 15px;
          background-color: #22232e;
          width: 100%;
          overflow-x: scroll;
          border-radius: 10px;
     }

     .text-code {
          font-family: 'Fira Code', monospace;
     }

     .cbox {
          background-color: #222;
          padding: 3px 7px;
          border-radius: 7px;
          border: 1px solid #333;
          font-family: 'Fira Code', monospace;
          font-size: 18px;
     }

     select {
          background-color: #1b1c26;
          border: none;
          padding: 5px 20px;
          border-radius: 10px;
          color: white;
          transition: .3s;
          cursor: pointer;
     }

     select:hover {
          background-color: #1f1f25;
     }

     .bg-app-dark-3 {
          background-color: #1b1c26;
     }

     .__route__input {
          width: auto;
          height: auto;
          padding: 5px;
          border: 2px solid #1b1c26;
          background-color: #323343;
          color: white;
     }

     .__route__input:hover,
     .__route__input:focus,
     .__route__input:active {
          border: 2px solid #242641;
     }

     .route__path__span {
          padding-top: 5px;
          padding-bottom: 5px;
          font-size: 20px;
          background-color: #1b1c26;
     }

     iframe {
          width: 100%;
          border: 3px solid #47da58;
          height: 500px;
     }


     @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap');

     body {
          font-family: 'Montserrat', sans-serif;
          margin: 0;
          padding: 0;
          background-color: #1b1c26;
          width: 100%;
          height: 100vh;
          color: white;
          border-bottom: 2px solid #47da58;
     }

     .ftext {
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          z-index: 2;
          text-align: center;
          padding: 10px;
          padding-top: 20px;
          padding-bottom: 20px;
          border-radius: 5px;
          background-color: #22232e;
          border-top: 2px solid #47da587c;
     }

     .bottom-bg-green {
          background-color: #47da58;
          padding: .5px;
          border-radius: 5px;
     }

     @media all and (max-width:40em) {
          .ftext {
               width: 100%;
          }
     }

     a {
          color: gray;
          text-decoration: none;
          transition: .3s;
     }

     a:hover {
          color: whitesmoke;
          text-decoration: none;
     }

     .bottom {
          position: fixed;
          bottom: 0;
          left: 0;
          z-index: 2;
     }

     .nav-app {
          background-color: #22232e;
          border-right: 2px solid #47da58;
          border-left: 2px solid #47da58;
          border-radius: 5px;
     }

     .navbar-toggler,
     .navbar-toggler:focus,
     .navbar-toggler:active,
     .navbar-toggler-icon:focus {
          outline: none;
          box-shadow: none;
          border: none;
          border: none;
          border-radius: 0;
     }

     .navbar-toggler svg {
          width: 30px;
     }

     /**
 * docs button
 */

     .docs-btn {
          color: white;
          width: 100%;
          background-color: #333;
          border-radius: 7px;
          border: 2px solid #333;
          padding: 8px 20px !important;
          transition: .3s;
     }

     .docs-btn:hover,
     .docs-btn:focus {
          background-color: #444;
          transition: .3s;
          border-color: #444;
     }

     /**
 * login
 */

     input {
          width: 100%;
          padding: 10px;
          outline: none;
          border: 2px solid #22232e;
          transition: .3s;
     }

     input:hover,
     input:focus,
     input:active {
          border: 2px solid #47da58;
     }

     /** login */

     .login-box {
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          width: 350px;
          min-height: 200px;
          border-radius: 10px;
          padding: 40px;
          box-sizing: border-box;
          transition: .5s;
     }

     /** custom bs color */

     .btn-framework {
          background-color: #47da58 !important;
          color: #000000;
          border: 1px solid #42cc52;
          transition: .25s;
     }

     .btn-framework:hover {
          color: #000000;
          background-color: #3dbe4c !important;
          border: 1px solid #39ab46;
     }

     .btn-framework:active,
     .btn-framework:focus {
          box-shadow: 0 0 0 0.23em #47da582d !important;
     }

     .text-framework {
          color: #47da58;
     }

     .btn-to-input {
          border-top-left-radius: 0;
          border-bottom-left-radius: 0;
     }

     .input-to-btn {
          border: 2px solid #3cb54a;
     }
</style>