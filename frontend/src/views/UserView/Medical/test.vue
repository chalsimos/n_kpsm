<template>
    <div>
      <input type="file" ref="fileInput" multiple @change="handleFileUpload">
      <div v-for="(image, index) in capturedImages" :key="index">
        <img :src="image.url" @click="previewImage(image)" style="max-width: 200px; cursor: pointer;">
        <span>{{ image.name }}</span>
        <button @click="removeImage(index)">Remove</button>
      </div>
      <button @click="toggleCamera">Use Camera</button>
      <vue-camera v-if="showCamera" ref="camera"></vue-camera>
      <button v-if="showCamera" @click="captureImage">Capture Image</button>
      <button v-if="showCamera" @click="finishCapture">Finish Capturing</button>
    </div>
  </template>
  
  <script>
  import VueCamera from 'vue-camera-lib';
  
  export default {
    data() {
      return {
        showCamera: false,
        capturedImages: []
      };
    },
    methods: {
      toggleCamera() {
        this.showCamera = !this.showCamera;
      },
      async captureImage() {
        const camera = this.$refs.camera;
        try {
          const stream = await camera.captureImage();
          const imageName = `Image ${this.capturedImages.length + 1}`; 
          this.capturedImages.push({ url: stream, name: imageName });
        } catch (error) {
          console.error("Error capturing image:", error);
        }
      },
      finishCapture() {
        const shouldCaptureAgain = confirm("Do you want to capture more images?");
        if (shouldCaptureAgain) {
          this.capturedImages = [];
        } else {
          this.showCamera = false;
        }
      },
      handleFileUpload(event) {
        const files = event.target.files;
        for (let i = 0; i < files.length; i++) {
          const file = files[i];
          const reader = new FileReader();
          reader.onload = (e) => {
            const imageUrl = e.target.result;
            this.capturedImages.push({ url: imageUrl, name: file.name });
          };
          reader.readAsDataURL(file);
        }
      },
      removeImage(index) {
        this.capturedImages.splice(index, 1);
      },
      previewImage(image) {
        console.log("Preview Image:", image);
      }
    },
    components: {
      VueCamera
    }
  };
  </script>
  