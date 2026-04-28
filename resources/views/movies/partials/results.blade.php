@include('movies.partials.movie_list')

<script>
function fetchMovies() {
    const params = new URLSearchParams();
    
    // القيم النصية
    const q = document.getElementById('searchInput').value;
    const year = document.getElementById('year').value;
    const rating = document.getElementById('rating').value;

    if (q) params.append('q', q);
    if (year) params.append('year', year);
    if (rating) params.append('rating', rating);

    // جمع التصنيفات (Tags)
    document.querySelectorAll('.category-checkbox:checked').forEach(el => {
        params.append('categories[]', el.value);
    });

    // جمع الاستوديوهات (Tags)
    document.querySelectorAll('.studio-checkbox:checked').forEach(el => {
        params.append('studios[]', el.value);
    });

    // إرسال الطلب
    fetch(`/search?${params.toString()}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.text())
    .then(data => {
        document.getElementById('results').innerHTML = data;
    });
}

// ربط الأحداث
document.getElementById('searchInput').addEventListener('keyup', fetchMovies);
document.getElementById('year').addEventListener('change', fetchMovies);
document.getElementById('rating').addEventListener('input', fetchMovies);

// تفعيل المستمع لكل الـ Checkboxes المخفية
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('filter')) {
        fetchMovies();
    }
});

</script> 