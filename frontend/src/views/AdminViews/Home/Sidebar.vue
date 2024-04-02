<template>


<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
	<div class="px-3 py-3 lg:px-5 lg:pl-3">
		<div class="flex items-center justify-between">
			<div class="flex items-center justify-start rtl:justify-end">
				<button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
					<span class="sr-only">Open sidebar</span>
					<svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
						<path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
					</svg>
					</button>
				<a href="https://flowbite.com" class="flex ms-2 md:me-24">
					<img src="https://flowbite.com/docs/images/logo.svg" class="h-8 me-3" alt="FlowBite Logo" />
					<span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">Flowbite</span>
				</a>
			</div>
			<div class="flex items-center">
				<div class="flex items-center ms-3">
					<div>
						<button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
							<span class="sr-only">Open user menu</span>
							<img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
						</button>
					</div>
					<div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
						<div class="px-4 py-3" role="none">
							<p class="text-sm text-gray-900 dark:text-white" role="none">
								Neil Sims
							</p>
							<p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
								neil.sims@flowbite.com
							</p>
						</div>
						<ul class="py-1" role="none">
							<li>
								<a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Dashboard</a>
							</li>
							<li>
								<a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Settings</a>
							</li>
							<li>
								<a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Earnings</a>
							</li>
							<li>
								<a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Sign out</a>
							</li>
						</ul>
					</div>
				</div>
				</div>
		</div>
	</div>
</nav>

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
	<div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
		<ul class="space-y-2 font-medium">
			<li data-tooltip-target="dashboard" data-tooltip-placement="right">
				<a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
					<img width="32" height="32" src="https://img.icons8.com/external-flaticons-lineal-color-flat-icons/64/external-dashboards-productivity-flaticons-lineal-color-flat-icons.png" alt="external-dashboards-productivity-flaticons-lineal-color-flat-icons"/>
					<span class="ms-3">Dashboard</span>
				</a>
			</li>

<div id="dashboard" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
	Dashboard
	<div class="tooltip-arrow" data-popper-arrow></div>
</div>
	<li data-tooltip-target="Education" data-tooltip-placement="right">
	<a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
		<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 64 64"><path fill="#86a7ac" d="M31.791 24.612v38.919c0 .32.227.589.491.589h31.473c.265 0 .487-.269.487-.589V24.613a.604.604 0 0 0-.132-.402s-.011-.006-.011-.001c0 0-.001-.012-.02-.018a.405.405 0 0 0-.325-.16H32.279c-.263 0-.49.271-.49.59"/><path fill="#6c888c" d="M51.856 34.411h3.98c.033 0 .064-.036.064-.071v-4.502c0-.039-.031-.069-.064-.069h-3.98s-.035.008-.045.021v.004c-.008.014-.018.025-.018.043v4.502c0 .037.028.072.063.072m0 7.579h3.98c.033 0 .064-.035.064-.07v-4.502c0-.04-.031-.069-.064-.069h-3.98s-.035.008-.045.022v.004c-.008.014-.018.025-.018.043v4.502c0 .034.028.07.063.07m6.644-7.579h3.981c.028 0 .062-.036.062-.071v-4.502c0-.039-.033-.069-.062-.069H58.5s-.035.008-.046.021v.004c-.008.014-.016.025-.016.043v4.502c0 .037.027.072.062.072m0 7.579h3.981c.028 0 .062-.035.062-.07v-4.502c0-.04-.033-.069-.062-.069H58.5s-.035.008-.046.022v.004c-.008.014-.016.025-.016.043v4.502c0 .034.027.07.062.07m-6.644 6.532h3.98c.033 0 .064-.036.064-.071v-4.502a.067.067 0 0 0-.064-.068h-3.98s-.035.008-.045.021v.004c-.008.014-.018.025-.018.043v4.502c0 .035.028.071.063.071m0 7.579h3.98c.033 0 .064-.035.064-.07v-4.502c0-.04-.031-.069-.064-.069h-3.98s-.035.008-.045.021v.004c-.008.015-.018.026-.018.044v4.502c0 .035.028.07.063.07m6.644-7.579h3.981c.028 0 .062-.036.062-.071v-4.502c0-.039-.033-.068-.062-.068H58.5s-.035.008-.046.021v.004c-.008.014-.016.025-.016.043v4.502c0 .035.027.071.062.071m0 7.579h3.981c.028 0 .062-.035.062-.07v-4.502c0-.04-.033-.069-.062-.069H58.5s-.035.008-.046.021v.004c-.008.015-.016.026-.016.044v4.502c0 .035.027.07.062.07"/><path fill="#86a7ac" d="M14.871 24.612v38.919c0 .32.225.589.488.589h31.477c.263 0 .485-.269.485-.589V24.613a.598.598 0 0 0-.132-.402l-.008-.006s-.013-.016-.022-.022a.401.401 0 0 0-.323-.16H15.361c-.262 0-.487.271-.487.59"/><path fill="#6c888c" d="M34.935 34.411h3.98c.031 0 .064-.036.064-.071v-4.502c0-.039-.033-.069-.064-.069h-3.98s-.037.008-.045.021v.004c-.008.014-.018.025-.018.043v4.502c0 .037.025.072.063.072m0 7.579h3.98c.031 0 .064-.035.064-.07v-4.502c0-.04-.033-.069-.064-.069h-3.98s-.037.008-.045.022v.004c-.008.014-.018.025-.018.043v4.502c0 .034.025.07.063.07m6.643-7.579h3.981c.032 0 .063-.036.063-.071v-4.502c0-.039-.031-.069-.063-.069h-3.981a.057.057 0 0 0-.045.021v.004c-.009.014-.017.025-.017.043v4.502c0 .037.027.072.062.072m0 7.579h3.981c.032 0 .063-.035.063-.07v-4.502c0-.04-.031-.069-.063-.069h-3.981a.055.055 0 0 0-.045.022v.004c-.009.014-.017.025-.017.043v4.502c0 .034.027.07.062.07m-6.643 6.532h3.98c.031 0 .064-.036.064-.071v-4.502c0-.039-.033-.068-.064-.068h-3.98s-.037.008-.045.021v.004c-.008.014-.018.025-.018.043v4.502c0 .035.025.071.063.071m0 7.579h3.98c.031 0 .064-.035.064-.07v-4.502c0-.04-.033-.069-.064-.069h-3.98s-.037.008-.045.021v.004c-.008.015-.018.026-.018.044v4.502c0 .035.025.07.063.07m6.643-7.579h3.981c.032 0 .063-.036.063-.071v-4.502c0-.039-.031-.068-.063-.068h-3.981a.057.057 0 0 0-.045.021v.004c-.009.014-.017.025-.017.043v4.502c0 .035.027.071.062.071m0 7.579h3.981c.032 0 .063-.035.063-.07v-4.502c0-.04-.031-.069-.063-.069h-3.981a.057.057 0 0 0-.045.021v.004c-.009.015-.017.026-.017.044v4.502c0 .035.027.07.062.07"/><path fill="#a2c3cb" d="M0 8.265V63.24c0 .456.258.833.562.833h36.145c.305 0 .561-.377.561-.833V8.265c0-.247-.059-.437-.149-.568l-.017-.016c0-.014-.008-.016-.02-.023a.438.438 0 0 0-.375-.226H.562c-.304 0-.562.379-.562.833"/><path fill="#405967" d="M13.62 64.094h10.247c.079 0 .154-.051.154-.116v-7.362c0-.063-.075-.112-.154-.112H13.62a.167.167 0 0 0-.107.033l-.006.004h-.004c-.016.021-.042.048-.042.075v7.362c0 .065.076.116.159.116"/><g fill="#86a7ac"><path d="M14.897 60.452h1.78s.027-.017.027-.032v-2.012l-.027-.031h-1.8v.002l-.008.012v2.02c0 .014 0 .031.028.031M2.43 37.202h32.841c.257 0 .52-.045.52-.089V31.48c0-.049-.263-.086-.52-.086H2.43c-.13 0-.286 0-.365.027v.004c-.063.018-.13.034-.13.055v5.632c0 .045.209.09.495.09m-.022 9.48h31.475c.251 0 .5-.045.5-.089V40.96c0-.049-.249-.086-.5-.086H2.408c-.128 0-.278.001-.351.027v.006c-.062.016-.125.031-.125.053v5.633c0 .044.197.089.476.089"/><path d="M10.322 37.218h4.979c.042 0 .079-.045.079-.089v-5.632c0-.049-.038-.087-.079-.087h-4.98c-.023 0-.047 0-.057.027v.004c0 .018-.02.033-.02.055v5.632c0 .044.03.09.078.09m0 9.484h4.979c.042 0 .079-.045.079-.088v-5.633c0-.05-.038-.087-.079-.087h-4.98c-.023 0-.047 0-.057.027v.006c0 .016-.02.031-.02.054v5.633c0 .043.03.088.078.088m19.898-9.484h4.981c.036 0 .079-.045.079-.089v-5.632c0-.049-.043-.087-.079-.087H30.22c-.02 0-.043 0-.056.027v.004c0 .018-.02.033-.02.055v5.632c0 .044.033.09.076.09m0 9.484h4.981c.036 0 .079-.045.079-.088v-5.633c0-.05-.043-.087-.079-.087H30.22c-.02 0-.043 0-.056.027v.006s-.02.031-.02.054v5.633c0 .043.033.088.076.088m-8.258-9.484h4.981c.042 0 .081-.045.081-.089v-5.632c0-.049-.04-.087-.081-.087h-4.981c-.02 0-.043.001-.055.027v.004c-.008.018-.02.033-.02.055v5.632c0 .044.032.09.075.09m0 9.484h4.981c.042 0 .081-.045.081-.088v-5.633c0-.05-.04-.087-.081-.087h-4.981c-.02 0-.043.001-.055.027v.006c-.008.016-.02.031-.02.054v5.633c0 .043.032.088.075.088m-1.229 13.75h1.78s.027-.017.027-.032v-2.012l-.016-.031h-1.792l-.018.004l-.004.008l-.006.012v2.02c0 .014.011.031.029.031"/></g><path fill="#dfe6eb" d="M28.21 19.408c0 5.289-4.291 9.576-9.58 9.576a9.576 9.576 0 0 1-9.576-9.576A9.575 9.575 0 0 1 18.63 9.83c5.289 0 9.58 4.287 9.58 9.578"/><path fill="#d0d6d9" d="M25.2 24.308c-5.292 0-9.582-4.287-9.582-9.576c0-1.758.487-3.402 1.311-4.819c-4.453.825-7.83 4.721-7.83 9.41c0 5.291 4.291 9.578 9.58 9.578c3.531 0 6.606-1.917 8.268-4.761a9.432 9.432 0 0 1-1.747.168"/><path fill="#97a8b3" d="M18.635 9.07c-5.7 0-10.34 4.638-10.34 10.338c0 5.7 4.64 10.337 10.34 10.337s10.334-4.638 10.334-10.337c0-5.7-4.635-10.338-10.334-10.338m0 18.663c-4.594 0-8.329-3.736-8.329-8.325c0-4.591 3.734-8.327 8.329-8.327c4.589 0 8.323 3.736 8.323 8.327c0 4.588-3.734 8.325-8.323 8.325"/><path fill="#84929b" d="M19.241 26.18c0 .463-.272.841-.614.841c-.335 0-.608-.377-.608-.841v-6.813c0-.466.272-.841.608-.841c.341 0 .614.375.614.841z"/><path fill="#788187" d="M20.322 14.283c.205-.417.62-.632.92-.484c.302.15.381.61.173 1.026l-2.188 4.417c-.206.417-.618.632-.92.483c-.302-.148-.379-.61-.171-1.024z"/></svg>
		<span class="flex-1 ms-3 whitespace-nowrap">Education</span>
		<span class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">Pro</span>
	</a>
	</li>
<div id="Education" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
	Education
	<div class="tooltip-arrow" data-popper-arrow></div>
</div>
	<li data-tooltip-target="General Request" data-tooltip-placement="right">
	<a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
		<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512"><path fill="#96A9B2" d="M465.624 390.73c2.375-4.033-140.634-133.403-140.634-133.403c-17.984-15.829-29.211-16.078-53.943 0c0 0-199.388 129.266-198.819 133.244l-.041.029c.01.035.034.058.05.09c.589 3.992 1.91 7.668 3.859 10.884c.832 1.373 1.944 2.523 2.995 3.719l-.075.049c.084.093.214.136.298.229c4.476 4.962 10.787 8.176 18.379 9.093c.119.015.203.078.322.093h.47c1.16.113 2.224.398 3.438.398h323.456c15.927 0 31.615-10.016 40.049-24.057c.087-.105.202-.18.284-.287z"/><path fill="#B9C5C6" d="M301.505 242.48L73.339 389.467l45.592-208.232c4.444-20.296 24.496-36.747 44.792-36.747h318.472c20.296 0 33.145 16.45 28.701 36.747l-45.592 208.232z"/><path fill="#EDECE6" d="m124.015 168.458l138.552 131.427c17.707 15.585 28.761 15.831 53.112 0l195.795-131.219c-1.748-5.254-5.179-9.405-9.416-12.715l2.693-1.801c-4.491-5.105-10.935-8.416-18.706-9.27l-326.329.011c-8.12.843-16.028 4.165-22.74 9.259l1.892 1.778c-5.621 3.266-10.813 7.345-14.853 12.53"/><path fill="#DCE2E2" d="M123.9 168.734c-2.339 3.971 138.467 131.347 138.467 131.347c17.707 15.585 28.761 15.831 53.112 0c0 0 196.315-127.274 195.755-131.19l.041-.029c-.01-.034-.033-.057-.049-.089c-.58-3.931-1.88-7.549-3.799-10.717c-.819-1.352-1.914-2.484-2.949-3.662l.074-.049c-.083-.091-.211-.134-.294-.226c-4.407-4.885-10.621-8.05-18.095-8.953c-.117-.014-.2-.077-.317-.091h-.463c-1.142-.111-2.19-.392-3.385-.392H163.525c-15.682 0-31.128 9.862-39.431 23.686c-.085.103-.199.177-.279.283z"/><path fill="#59CAFC" d="M94.447 208.62H14.44c-6.627 0-12-5.373-12-12s5.373-12 12-12h80.007c6.627 0 12 5.373 12 12s-5.372 12-12 12m-13.108 70.236c0-6.627-5.373-12-12-12H14.44c-6.627 0-12 5.373-12 12s5.373 12 12 12h54.899c6.628 0 12-5.373 12-12m-18.215 82.237c0-6.627-5.373-12-12-12H14.44c-6.627 0-12 5.373-12 12s5.373 12 12 12h36.684c6.627 0 12-5.373 12-12"/></svg>
		<span class="flex-1 ms-3 whitespace-nowrap">General Request</span>
		<span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">3</span>
	</a>
	</li>
<div id="General Request" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
	General Request
	<div class="tooltip-arrow" data-popper-arrow></div>
</div>
	<li data-tooltip-target="Medical" data-tooltip-placement="right">
	<a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
		<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 128 128"><path fill="#BACFD4" d="M4.36 94.22S4.3 30.27 4.3 28.44c0-2.01 1.05-2.36 2.73-2.41c1.61-.05 112.48-.1 114.23-.05c2.29.06 2.5 1.5 2.58 3.33c.08 1.83.02 64.96.02 64.96l-62.63 1.16z"/><path fill="#6BA4AE" d="M4.36 94.22s.03 26.54.03 27.92s1 2.38 2.89 2.38s112.59-.25 114.1-.25s2.38-1.38 2.51-3.64c.13-2.26-.01-26.37-.01-26.37z"/><path fill="#546F7A" d="m33.83 102.57l.11 21.87h59.32l.1-22.29z"/><path fill="#B9CED3" d="M40.1 103.67v20.75h3.3v-21.04zm21.93-.39v21.11h3.34v-21.43zm22.61.04v21.12h3.43v-21.57z"/><path fill="#F1EDEC" d="M39.45 94.47S39.1 8.98 39.1 7.13s.71-3.31 2.56-3.43c1.85-.12 41.76-.12 43.38 0c1.62.12 2.65 1.12 2.65 3.2s.23 87.57.23 87.57l16.89 2.08v5.09c0 1.62-.58 2.26-2.26 2.26H23.59c-1.5 0-1.97-1.56-1.97-3.18v-5.44z"/><path fill="#FEFFFD" d="m21.66 97.05l83.15-.04s.05-1.79 0-2.68c-.07-1.26-1.14-1.3-3.58-1.3H23.6c-1.06 0-1.88.37-1.96 1.43s.02 2.54.02 2.59"/><path fill="#546F7A" d="M47.49 65.41c.23.23 31.31.37 31.51.16c.18-.19.32-11.69.08-11.93c-.31-.31-31.35-.24-31.59 0c-.24.24-.24 11.52 0 11.77m.08 9.75c-.41.14-.08 11.69-.08 11.69l31.67-.24s.28-11.18-.24-11.44c-.32-.17-30.86-.17-31.35-.01m44.49-41.35v12.74h12.01v-12.9zm16.76-.16h11.37l.16 12.74h-11.61zm-.16 20.31l-.08 12.33h11.53l.16-12.33zm-4.59-.08H91.98v12.41h12.25zm.08 20.47H92.06V87h12.25c0 .01-.32-12.81-.16-12.65m4.51-.08h11.44v12.9h-11.44s.12-13.02 0-12.9m-84.3 12.57V74.03l11.77-.16v12.81zm-4.51-.08V73.95H7.84l.08 12.98c0-.01 12.09-.17 11.93-.17M7.76 53.64h12.17v12.33H7.76zm16.76-.08v12.41h11.45V53.64zm.16-20.39H35.8v12.98H24.68zm-4.99.48l-11.77-.08v12.41h11.77z"/><path fill="#DD0C26" d="M56.94 20.78s-.02-12.35.07-13.19c.08-.85.59-1.02 1.19-1.02c.59 0 10.85 0 11.44.08c.59.08.85.59.85 1.53v12.54s12.2.08 12.71.08c.51 0 1.02.59 1.02 1.27v11.18c0 .76-.08 1.53-1.02 1.69s-12.79 0-12.79 0v14.09c0 .58-.49 1.08-1.31 1.14s-10.99 0-11.56 0s-.57-1.71-.57-2.29V35.24H43.69c-.58 0-.83-.57-.89-1.65c-.06-1.08.04-10.86.06-11.43c.04-.89.38-1.32 1.01-1.38c.62-.05 13.07 0 13.07 0"/><path fill="#FFF" d="M62.13 11.57h3.16v34.1h-3.16z"/><path fill="#FFF" d="M47.69 26.26h31.56v3.21H47.69z"/></svg>
		<span class="flex-1 ms-3 whitespace-nowrap">Medical</span>
	</a>
	</li>
<div id="Medical" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
	Medical
	<div class="tooltip-arrow" data-popper-arrow></div>
</div>
	<li data-tooltip-target="Request" data-tooltip-placement="right">
	<a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
		<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><g fill="none"><rect width="30" height="22" x="1" y="8" fill="#B4ACBC" rx="1.5"/><rect width="28" height="18" x="2" y="10" fill="#CDC4D6" rx="1"/><path fill="#E1D8EC" d="m30 26.4l-12.971-7.783a2 2 0 0 0-2.058 0L2 26.4V28a1 1 0 0 0 1 1h26a1 1 0 0 0 1-1z"/><path fill="#998EA4" d="M2 12.766V11h28v1.766L17.544 20.24a3 3 0 0 1-3.088 0z"/><path fill="#F3EEF8" d="M2 11.6V10a1 1 0 0 1 1-1h26a1 1 0 0 1 1 1v1.6l-12.971 7.783a2 2 0 0 1-2.058 0z"/><path fill="#F92F60" d="M18.94 3.47v7.1c0 .16.13.28.28.28h.98c.62 0 .95.74.53 1.2l-4.01 4.41a.72.72 0 0 1-1.06 0l-4.02-4.41a.718.718 0 0 1 .53-1.2h.98c.16 0 .28-.13.28-.28v-7.1c0-.26.21-.47.47-.47h4.58c.25 0 .46.21.46.47"/></g></svg>
		<span class="flex-1 ms-3 whitespace-nowrap">Request</span>
	</a>
	</li>
<div id="Request" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
	Request
	<div class="tooltip-arrow" data-popper-arrow></div>
</div>
	<li>
		<a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
			<svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
				<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"/>
			</svg>
			<span class="flex-1 ms-3 whitespace-nowrap">Sign In</span>
		</a>
	</li>
	<li>
		<a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
			<svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
				<path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z"/>
				<path d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z"/>
				<path d="M8.961 16a.93.93 0 0 0 .189-.019l3.4-.679a.961.961 0 0 0 .49-.263l6.118-6.117a2.884 2.884 0 0 0-4.079-4.078l-6.117 6.117a.96.96 0 0 0-.263.491l-.679 3.4A.961.961 0 0 0 8.961 16Zm7.477-9.8a.958.958 0 0 1 .68-.281.961.961 0 0 1 .682 1.644l-.315.315-1.36-1.36.313-.318Zm-5.911 5.911 4.236-4.236 1.359 1.359-4.236 4.237-1.7.339.341-1.699Z"/>
			</svg>
			<span class="flex-1 ms-3 whitespace-nowrap">Sign Up</span>
		</a>
	</li>
	</ul>
	</div>
</aside>

<div class="p-4 sm:ml-64">
	<div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
		<div class="grid grid-cols-3 gap-4 mb-4">
			<div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
				<p class="text-2xl text-gray-400 dark:text-gray-500">
					<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
					</svg>
				</p>
			</div>
			<div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
				<p class="text-2xl text-gray-400 dark:text-gray-500">
					<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
					</svg>
				</p>
			</div>
			<div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
				<p class="text-2xl text-gray-400 dark:text-gray-500">
					<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
					</svg>
				</p>
			</div>
		</div>
		<div class="flex items-center justify-center h-48 mb-4 rounded bg-gray-50 dark:bg-gray-800">
			<p class="text-2xl text-gray-400 dark:text-gray-500">
				<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
					<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
				</svg>
			</p>
		</div>
		<div class="grid grid-cols-2 gap-4 mb-4">
			<div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
				<p class="text-2xl text-gray-400 dark:text-gray-500">
					<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
					</svg>
				</p>
			</div>
			<div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
				<p class="text-2xl text-gray-400 dark:text-gray-500">
					<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
					</svg>
				</p>
			</div>
			<div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
				<p class="text-2xl text-gray-400 dark:text-gray-500">
					<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
					</svg>
				</p>
			</div>
			<div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
				<p class="text-2xl text-gray-400 dark:text-gray-500">
					<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
					</svg>
				</p>
			</div>
		</div>
		<div class="flex items-center justify-center h-48 mb-4 rounded bg-gray-50 dark:bg-gray-800">
			<p class="text-2xl text-gray-400 dark:text-gray-500">
				<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
					<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
				</svg>
			</p>
		</div>
		<div class="grid grid-cols-2 gap-4">
			<div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
				<p class="text-2xl text-gray-400 dark:text-gray-500">
					<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
					</svg>
				</p>
			</div>
			<div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
				<p class="text-2xl text-gray-400 dark:text-gray-500">
					<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
					</svg>
				</p>
			</div>
			<div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
				<p class="text-2xl text-gray-400 dark:text-gray-500">
					<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
					</svg>
				</p>
			</div>
			<div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
				<p class="text-2xl text-gray-400 dark:text-gray-500">
					<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
					</svg>
				</p>
			</div>
		</div>
	</div>
</div>
<Foot />
</template>

<script>
import Foot from '@/views/AdminViews/Home/Footer.vue'

export default {
	components: {
		Foot
	}
}
</script>
