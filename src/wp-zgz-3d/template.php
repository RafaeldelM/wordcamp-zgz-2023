<?php ?>

<script type="module">
  import * as THREE from 'https://cdn.jsdelivr.net/npm/three@0.121.1/build/three.module.js';
  import {
    OrbitControls
  } from 'https://cdn.jsdelivr.net/npm/three@0.121.1/examples/jsm/controls/OrbitControls.js';
  import {
    GLTFLoader
  } from 'https://cdn.jsdelivr.net/npm/three@0.121.1/examples/jsm/loaders/GLTFLoader.js'

  const myCanvas = document.querySelector('#myCanvas');

  const scene = new THREE.Scene();

  // Creamos luz ambiental
  const color = 0xFFFFFF;
  const intensidad = 1;
  const luzAmbiente = new THREE.AmbientLight(color, intensidad);
  luzAmbiente.castShadow = true;
  scene.add(luzAmbiente);

  // Creamos una luz direccional
  const luzDireccional = new THREE.DirectionalLight(0xffffff, 1);
  luzDireccional.position.set(0, 1, 0); //default; light shining from top
  luzDireccional.castShadow = true; // default false
  scene.add(luzDireccional);

  // Creamos la camara
  const camera = new THREE.PerspectiveCamera(50, myCanvas.offsetWidth / myCanvas.offsetHeight);
  camera.position.set(2, 2, 2);
  camera.lookAt(scene.position);

  // Creamos el renderizador
  const renderer = new THREE.WebGLRenderer({
    antialias: true,
    canvas: myCanvas,
  });
  renderer.setClearColor(0xffffff, 1.0);
  renderer.setPixelRatio(window.devicePixelRatio);
  renderer.setSize(myCanvas.offsetWidth, myCanvas.offsetHeight);
  renderer.shadowMapEnabled = true;

  renderer.setAnimationLoop(() => {
    orbitControls.update();
    renderer.render(scene, camera);
  });


  // Controles de rotación
  const orbitControls = new OrbitControls(
    camera,
    renderer.domElement
  );
  orbitControls.maxPolarAngle = Math.PI * 0.5;
  orbitControls.minDistance = 0.1;
  orbitControls.maxDistance = 100;
  orbitControls.autoRotate = true;
  orbitControls.autoRotateSpeed = 1.0;

  cargarSofa('gris');

  window.addEventListener('resize', onWindowResize, false);

  function onWindowResize() {
    camera.aspect = myCanvas.offsetWidth / myCanvas.offsetHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(myCanvas.offsetWidth, myCanvas.offsetHeight);
  }


  document.getElementById('boton_gris').onclick = function() {
    cargarSofa('gris');
  }


  document.getElementById('boton_azul').onclick = function() {
    cargarSofa('azul');
  }

  document.getElementById('boton_beige').onclick = function() {
    cargarSofa('beige');
  }

  document.getElementById('boton_rojo').onclick = function() {
    cargarSofa('rojo');
  }

  function cargarSofa(nombre_color) {
    let nombre_modelo = 'sofa_gris.glb';
    switch (nombre_color) {
      case 'gris':
        nombre_modelo = 'sofa_gris.glb';
        break;
      case 'beige':
        nombre_modelo = 'sofa_beige.glb';
        break;
      case 'rojo':
        nombre_modelo = 'sofa_rojo.glb';
        break;
      case 'azul':
        nombre_modelo = 'sofa_azul.glb';
        break;
      default:
        nombre_modelo = 'sofa_gris.glb';
    }

    const loader = new GLTFLoader()
    loader.load(
      'https://wordcamp.elementor.cloud/wp-content/uploads/2023/01/' + nombre_modelo,
      function(gltf) {
        scene.add(gltf.scene)

      },
      (xhr) => {
        console.log((xhr.loaded / xhr.total) * 100 + '% loaded')
      },
      (error) => {
        console.log(error)
      }
    )
  }
</script>
<canvas id="myCanvas" style="width: 100%; height: 100%;outline:none"></canvas>