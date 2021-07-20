<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>test</title>

    <style>

:root {
  --gutter: 20px;
}

.app {
  padding: var(--gutter) 0;
  display: grid;
  grid-gap: var(--gutter) 0;
  grid-template-columns: var(--gutter) 1fr var(--gutter);
  align-content: start;
}

.app > * {
  grid-column: 2 / -2;
}

.app > .full {
  grid-column: 1 / -1;
}

.hs {
  display: grid;
  grid-gap: calc(var(--gutter) / 2);
  grid-template-columns: 10px repeat(6, calc(50% - var(--gutter) * 2)) 10px;
  grid-template-rows: minmax(150px, 1fr);
  
  overflow-x: scroll;
  scroll-snap-type: x proximity;
  padding-bottom: calc(.75 * var(--gutter));
  margin-bottom: calc(-.5 * var(--gutter));
}

.hs:before,
.hs:after {
  content: '';
}

/* Hide scrollbar */
.hide-scroll {
  overflow-y: hidden;
  margin-bottom: calc(-.1 * var(--gutter));
}


/* Demo styles */

html,
body {
  height: 100%;
}

body {
  display: grid;
  place-items: center;
  background: #456173;
}

ul {
  list-style: none;
  padding: 0;
}

h1,
h2,
h3 {
  margin: 0;
}

.app {
  width: 375px;
  height: 667px;
  background: #DBD0BC;
  overflow-y: scroll;
}

.hs > li,
.item {
  scroll-snap-align: center;
  padding: calc(var(--gutter) / 2 * 1.5);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background: #fff;
  border-radius: 8px;
}



    </style>

</head>
<body>

    <div class="app">
    <h1>Some headline</h1>

    <div class="full hide-scroll">
    
        <ul class="hs">
        <li class="item">test</li>
        <li class="item">test</li>
        <li class="item">test</li>
        <li class="item">test</li>
        <li class="item">test</li>
        <li class="item">test</li>
        </ul>

    </div>

    <div class="container">
        <div class="item">
        <h3>Block for context</h3>
        </div>
    </div>
    </div>

</body>