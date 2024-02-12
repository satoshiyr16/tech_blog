let windowWidth = document.documentElement.clientWidth;
//   const canvas = document.getElementById('waveCanvas');
//   canvas.width = windowWidth;
//   canvas.height = 200;
//   const context = canvas.getContext('2d');

//   const colorList = ['#7fdbff', '#39CCCC', '#3D99F6', '#14B6D4', '#67E6DC'];
//   let seconds = 0;
//   let t = 0;

//   const handleResize = () => {
//     windowWidth = document.documentElement.clientWidth;
//     canvas.width = windowWidth;
//     initWaveAnimation();
//   };

//   // 波形の基本的な形状を描画、t:時間 zoom:ズーム delay:遅延
//   const drawSine = (t, zoom, delay) => {
//     // x座標：unitで波形の間隔を密にするか定める
//     const unit = 100;
//     // y座標：canvasの高さの半分の位置を中心とする
//     const xAxis = Math.floor(canvas.height / 2);
//     let x, y;
//     // 少しwidthの幅を超えて余分に描画するよう設定
//     for (let i = 0; i <= canvas.width + 10; i += 10) {
//       // 現在のポイントのキャンバス上での相対位置を計算し、波形の進行速度や波長を制御
//       x = t + (-xAxis + i) / unit / zoom;
//       // xの値に基づいて、yを計算し、波の振幅（高さ）を調整。delayを用いてズレを生じさせる
//       y = Math.sin(x - delay) / 3;
//       // それらのポイントを結ぶ
//       context.lineTo(i, unit * y + xAxis);
//     }
//   };

//   const drawSingleWave = (color, alpha, zoom, delay, t) => {
//     context.strokeStyle = color;
//     context.lineWidth = 1;
//     context.globalAlpha = alpha;
//     context.beginPath();
//     drawSine(t / 0.5, zoom, delay);
//     context.stroke();
//   };

//   const drawWave = (colorList, seconds, t) => {
//     colorList.forEach((color, index) => {
//       const alpha = [0.8, 0.5, 0.3, 0.2, 0.5][index];
//       const zoom = [3, 4, 1.6, 3, 1.6][index];
//       const delay = [0, 0, 0, 100, 250][index];
//       drawSingleWave(color, alpha, zoom, delay, t);
//     });
//   };

//   const initWaveAnimation = () => {
//     context.clearRect(0, 0, canvas.width, canvas.height);
//     drawWave(colorList, seconds, t);
//     seconds += 0.02;
//     t = seconds * Math.PI;
//     requestAnimationFrame(initWaveAnimation);
//   };

//   window.addEventListener('resize', handleResize);
//   initWaveAnimation();

//   return () => {
//     window.removeEventListener('resize', handleResize);
//   };
