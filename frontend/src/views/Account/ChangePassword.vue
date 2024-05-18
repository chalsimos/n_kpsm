<script setup>
import { onMounted } from "vue";
import { Input, Ripple, initTWE } from "tw-elements";

onMounted(() => {
  initTWE({ Input, Ripple });
});
</script>

<template>
  <section class="flex justify-center pt-28">
    <div class="container h-full">
      <div
        class="flex h-full flex-wrap items-center justify-center text-neutral-800 dark:text-neutral-200"
      >
        <div class="w-full">
          <div class="block rounded-lg bg-white shadow-lg dark:bg-neutral-800">
            <div class="g-0 lg:flex lg:flex-wrap">
              <div class="px-4 md:px-0 lg:w-6/12">
                <div class="md:mx-6 md:p-12">
                  <div class="text-center">
                    <img
                      class="mx-auto w-48"
                      src="../../assets/kpms.png"
                      alt="logo"
                    />
                    <h4
                      class="mb-12 mt-1 pb-1 text-xl text-orange-600 font-semibold"
                    >
                      KPSM
                    </h4>
                  </div>
                  <form class="max-w-sm mx-auto">
                    <div class="mb-5">
                      <label
                        for="password"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >New Password</label
                      >
                      <input
                        type="password"
                        id="password"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        required
                      />
                    </div>
                    <div class="mb-5">
                      <label
                        for="password"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Confirm New Password</label
                      >
                      <input
                        type="password"
                        id="password"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        required
                      />
                    </div>
                    <button
                      type="submit"
                      class="inline-block w-full rounded bg-primary px-7 pb-2.5 pt-3 text-sm font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
                      data-twe-ripple-init
                      data-twe-ripple-color="light"
                    >
                      Update Password
                    </button>
                  </form>
                </div>
              </div>
              <div
                class="right-card mt-1 flex items-center rounded-b-lg lg:w-6/12 lg:rounded-e-lg lg:rounded-bl-none"
              >
                <img
                  class="mx-auto h-[58vh] w-[65vh]"
                  src="../../assets/congPA.jpg"
                  alt="logo"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
export default {
  mounted() {
  },
};
</script>
<style>
.signup-button {
  background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
}
.right-card {
  background: #e5aa35;
  background: linear-gradient(135deg, #e5aa35, #fcc071);
}
</style>
