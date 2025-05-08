<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>College Search Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Header -->
  <header class="bg-white shadow p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-orange-500">Yadhu College Search</h1>
    <input id="mainSearch" type="text" placeholder="Search All Colleges" class="border border-gray-300 p-2 rounded w-1/2" />
  </header>

  <div class="flex">
    <!-- Sidebar -->
    <aside class="w-1/4 bg-black text-white p-4 shadow-md">
      <h2 class="font-semibold mb-2">Filter Colleges</h2>
      <div class="mb-4">
        <label class="block text-sm">Name</label>
        <input type="text" id="filterName" class="border p-1 w-full bg-gray-800 text-white placeholder-gray-400" />
      </div>
      <div class="mb-4">
        <label class="block text-sm">City</label>
        <input type="text" id="filterCity" class="border p-1 w-full bg-gray-800 text-white placeholder-gray-400" />
      </div>
      <div class="mb-4">
        <label class="block text-sm">State</label>
        <input type="text" id="filterState" class="border p-1 w-full bg-gray-800 text-white placeholder-gray-400" />
      </div>
      <div class="mb-4">
        <label class="block text-sm">Ranking (less than)</label>
        <input type="number" id="filterRanking" class="border p-1 w-full bg-gray-800 text-white placeholder-gray-400" />
      </div>
      <button onclick="applyFilters()" class="bg-orange-500 text-white px-4 py-2 rounded w-full">Filter</button>

      <h2 class="font-semibold mt-8 mb-2">Wishlist</h2>
      <button onclick="toggleWishlist()" class="bg-orange-500 text-white px-4 py-1 rounded mb-2">Show Wishlist</button>
      <ul id="wishlist" class="text-sm list-disc pl-5 space-y-1 hidden text-white"></ul>
    </aside>

    <!-- Main Content -->
    <main class="w-3/4 p-6">
      <div id="collegeCards" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6"></div>
      <div class="mt-6 flex justify-center space-x-2" id="pagination"></div>
    </main>
  </div>

  <script>
    const colleges = [
      { name: "Harvard University", city: "Cambridge", state: "MA", ranking: 1, image: "images/1.jpg" },
      { name: "Stanford University", city: "Stanford", state: "CA", ranking: 2, image: "images/2.jpg" },
      { name: "MIT", city: "Cambridge", state: "MA", ranking: 3, image: "images/3.jpg" },
      { name: "Yale University", city: "New Haven", state: "CT", ranking: 4, image: "images/4.jpg" },
      { name: "Princeton University", city: "Princeton", state: "NJ", ranking: 5, image: "images/5.jpg" },
      { name: "Columbia University", city: "New York", state: "NY", ranking: 6, image: "images/6.jpg" },
      { name: "Caltech", city: "Pasadena", state: "CA", ranking: 7, image: "images/7.jpg" },
      { name: "University of Chicago", city: "Chicago", state: "IL", ranking: 8, image: "images/8.jpg" },
      { name: "Duke University", city: "Durham", state: "NC", ranking: 9, image: "images/9.jpg" },
      { name: "University of Pennsylvania", city: "Philadelphia", state: "PA", ranking: 10, image: "images/10.jpg" },
      { name: "Johns Hopkins University", city: "Baltimore", state: "MD", ranking: 11, image: "images/11.jpg" },
      { name: "Northwestern University", city: "Evanston", state: "IL", ranking: 12, image: "images/12.jpg" },
      { name: "Cornell University", city: "Ithaca", state: "NY", ranking: 13, image: "images/default.jpg" },
      { name: "Brown University", city: "Providence", state: "RI", ranking: 14, image: "images/default.jpg" },
      { name: "UCLA", city: "Los Angeles", state: "CA", ranking: 15, image: "images/default.jpg" },
      { name: "UC Berkeley", city: "Berkeley", state: "CA", ranking: 16, image: "images/default.jpg" },
      { name: "University of Michigan", city: "Ann Arbor", state: "MI", ranking: 17, image: "images/default.jpg" },
      { name: "University of Virginia", city: "Charlottesville", state: "VA", ranking: 18, image: "images/default.jpg" },
      { name: "University of North Carolina", city: "Chapel Hill", state: "NC", ranking: 19, image: "images/default.jpg" },
      { name: "University of Florida", city: "Gainesville", state: "FL", ranking: 20, image: "images/default.jpg" },
    ];

    let currentPage = 1;
    const cardsPerPage = 10;
    let filteredColleges = [...colleges];
    const wishlist = [];

    document.getElementById("mainSearch").addEventListener("input", function () {
      const query = this.value.toLowerCase();
      filteredColleges = colleges.filter(college =>
        college.name.toLowerCase().includes(query) ||
        college.city.toLowerCase().includes(query) ||
        college.state.toLowerCase().includes(query)
      );
      currentPage = 1;
      renderCards();
    });

    function renderCards() {
      const start = (currentPage - 1) * cardsPerPage;
      const end = start + cardsPerPage;
      const display = filteredColleges.slice(start, end);

      document.getElementById("collegeCards").innerHTML = display.map(college => `
        <div class="bg-white rounded shadow p-4 text-center">
          <img src="${college.image}" onerror="this.onerror=null; this.src='images/default.jpg';" alt="College" class="w-full h-40 object-cover rounded mb-2">
          <h3 class="font-semibold text-lg">${college.name}</h3>
          <p class="text-sm text-gray-600">${college.city}, ${college.state}</p>
          <p class="text-sm font-bold text-orange-600">Ranking: ${college.ranking}</p>
          <button class="mt-2 bg-orange-500 text-white px-3 py-1 rounded text-sm" onclick='toggleWishlistItem("${college.name}")'>${wishlist.includes(college.name) ? 'Remove from Wishlist' : 'Add to Wishlist'}</button>
        </div>
      `).join("");

      renderPagination();
    }

    function renderPagination() {
      const totalPages = Math.ceil(filteredColleges.length / cardsPerPage);
      document.getElementById("pagination").innerHTML = `
        <button onclick="prevPage()" class="px-3 py-1 bg-white border rounded">Prev</button>
        ${Array.from({ length: totalPages }, (_, i) => i + 1).map(i => `
          <button onclick="goToPage(${i})" class="px-3 py-1 ${i === currentPage ? 'bg-orange-500 text-white' : 'bg-white border'} rounded">${i}</button>
        `).join("")}
        <button onclick="nextPage()" class="px-3 py-1 bg-white border rounded">Next</button>
      `;
    }

    function goToPage(page) {
      const totalPages = Math.ceil(filteredColleges.length / cardsPerPage);
      if (page >= 1 && page <= totalPages) {
        currentPage = page;
        renderCards();
      }
    }

    function prevPage() {
      if (currentPage > 1) {
        currentPage--;
        renderCards();
      }
    }

    function nextPage() {
      const totalPages = Math.ceil(filteredColleges.length / cardsPerPage);
      if (currentPage < totalPages) {
        currentPage++;
        renderCards();
      }
    }

    function applyFilters() {
      const name = document.getElementById("filterName").value.toLowerCase();
      const city = document.getElementById("filterCity").value.toLowerCase();
      const state = document.getElementById("filterState").value.toLowerCase();
      const ranking = document.getElementById("filterRanking").value;

      filteredColleges = colleges.filter(college => {
        return (
          (!name || college.name.toLowerCase().includes(name)) &&
          (!city || college.city.toLowerCase().includes(city)) &&
          (!state || college.state.toLowerCase().includes(state)) &&
          (!ranking || college.ranking <= parseInt(ranking))
        );
      });

      currentPage = 1;
      renderCards();
    }

    function toggleWishlistItem(name) {
      const index = wishlist.indexOf(name);
      if (index === -1) {
        wishlist.push(name);
      } else {
        wishlist.splice(index, 1);
      }
      renderWishlist();
      renderCards();
    }

    function renderWishlist() {
      const wishlistEl = document.getElementById("wishlist");
      wishlistEl.innerHTML = wishlist.map(item => `<li>${item}</li>`).join("");
    }

    function toggleWishlist() {
      const wishlistEl = document.getElementById("wishlist");
      wishlistEl.classList.toggle("hidden");
    }

    renderCards();
  </script>

</body>
</html>
