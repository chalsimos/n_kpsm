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
                        for="email"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Email</label
                      >
                      <input
                        type="email"
                        id="email"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        placeholder="name@gmail.com"
                        required
                      />
                    </div>
                    <div class="mb-5">
                      <label
                        for="password"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Password</label
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
                        for="repeat-password"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Confirm Password</label
                      >
                      <input
                        type="password"
                        id="repeat-password"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        required
                      />
                    </div>
                    <div class="flex items-start mb-5">
                      <div class="flex items-center h-5">
                        <input
                          id="terms"
                          type="checkbox"
                          value=""
                          class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800"
                          required
                        />
                      </div>
                      <label
                        for="terms"
                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                        >I agree with the
                        <a
                          href="#"
                          class="text-blue-600 hover:underline dark:text-blue-500"
                          >terms and conditions</a
                        ></label
                      >
                    </div>
                    <button
                      type="submit"
                      class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                      Register new account
                    </button>
                  </form>
                </div>
              </div>
              <div
                class="right-card mt-1 flex items-center rounded-b-lg lg:w-6/12 lg:rounded-e-lg lg:rounded-bl-none"
              >
                  <img
                      class="mx-auto h-[70vh] w-[70vh]"
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
    document.title = "Register";
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
