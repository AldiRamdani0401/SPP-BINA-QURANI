<!-- Shimmer -->
<style>
  .shimmer {
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background:rgb(68, 101, 57);
    background-size: 800px 104px;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    animation: loading 1.2s infinite;
    z-index: 999;
  }

  @keyframes loading {
    0% {
      background-position: -800px 0;
    }
    100% {
      background-position: 800px 0;
    }
  }

  .shimmer-text {
    font-size: 24px;
    color: #999;
  }
</style>

<div class="shimmer" id="shimmer">
  <div class="flex flex-row justify-center items-center gap-2 px-2">

  <img src="http://localhost:100/images/logo/_/logo" alt="logo bina qur'ani" class="h-52">
  <div class="flex flex-col text-white text-left">
    <span class="font-semibold text-4xl">Portal Web SPP</span>
    <span class="text-3xl">Bina Qur'ani Karawang</span>
  </div>
  </div>
</div>

<script>
  setTimeout(function() {
    document.getElementById('shimmer').style.display = 'none';
  }, 2000);
</script>