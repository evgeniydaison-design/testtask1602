<template>
  <div class="min-h-screen bg-gray-50">
    <header class="bg-white border-b border-gray-200 sticky top-0 z-10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-14 md:h-16">
          <NuxtLink to="/" class="flex items-center gap-2">
            <span class="text-xl md:text-2xl font-bold text-primary-600">Всё лето</span>
          </NuxtLink>
          <nav class="flex items-center gap-4">
            <NuxtLink
              to="/catalog"
              class="text-gray-600 hover:text-primary-600 font-medium transition-colors"
            >
              Каталог
            </NuxtLink>
          </nav>
        </div>
      </div>
    </header>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
      <slot />
    </main>
    <footer class="bg-white border-t border-gray-200 mt-auto">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <p class="text-center text-gray-500 text-sm">© Всё лето — каталог жилья для отдыха</p>
      </div>
    </footer>
  </div>
</template>
