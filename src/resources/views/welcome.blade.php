<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PlanTravel - Buat Rencana Trip Baru</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: #f0f2f5;
      font-family: 'Inter', sans-serif;
      color: #1a2c3e;
    }

    /* Layout utama */
    .app-container {
      display: flex;
      min-height: 100vh;
    }

    /* SIDEBAR */
    .sidebar {
      width: 280px;
      background: linear-gradient(180deg, #1a3f4f 0%, #0e2a36 100%);
      color: white;
      padding: 28px 20px;
      position: fixed;
      height: 100vh;
      overflow-y: auto;
    }

    .logo {
      font-size: 1.5rem;
      font-weight: 800;
      margin-bottom: 32px;
      display: flex;
      align-items: center;
      gap: 10px;
      color: #ffb347;
    }

    .logo i {
      font-size: 1.8rem;
    }

    .nav-section {
      margin-bottom: 28px;
    }

    .nav-section h4 {
      font-size: 0.7rem;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: #7f9eb5;
      margin-bottom: 12px;
      font-weight: 600;
    }

    .nav-items {
      list-style: none;
    }

    .nav-items li {
      padding: 10px 12px;
      margin-bottom: 4px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      gap: 12px;
      cursor: pointer;
      transition: 0.2s;
      font-size: 0.9rem;
      font-weight: 500;
      color: #cfdfe8;
    }

    .nav-items li i {
      width: 22px;
      color: #ffb347;
    }

    .nav-items li:hover {
      background: rgba(255, 180, 71, 0.15);
      color: white;
    }

    /* MAIN CONTENT */
    .main-content {
      flex: 1;
      margin-left: 280px;
      padding: 28px 36px;
    }

    /* Breadcrumb */
    .breadcrumb {
      display: flex;
      gap: 8px;
      margin-bottom: 24px;
      font-size: 0.85rem;
      color: #6f8eaa;
    }

    .breadcrumb a {
      text-decoration: none;
      color: #ff8c42;
    }

    /* Card Form */
    .form-card {
      background: white;
      border-radius: 28px;
      padding: 32px;
      box-shadow: 0 8px 28px rgba(0, 0, 0, 0.05);
      max-width: 800px;
    }

    .form-title {
      font-size: 1.6rem;
      font-weight: 700;
      margin-bottom: 8px;
      color: #1e3a4d;
    }

    .form-subtitle {
      color: #6f8eaa;
      margin-bottom: 32px;
      font-size: 0.9rem;
    }

    .form-group {
      margin-bottom: 24px;
    }

    .form-group label {
      display: block;
      font-weight: 600;
      margin-bottom: 8px;
      color: #2c4b6c;
      font-size: 0.85rem;
    }

    .form-group label .required {
      color: #e74c3c;
      margin-left: 4px;
    }

    .form-group input, .form-group select {
      width: 100%;
      padding: 12px 16px;
      border: 1.5px solid #e2e8f0;
      border-radius: 16px;
      font-size: 0.95rem;
      font-family: 'Inter', sans-serif;
      transition: 0.2s;
    }

    .form-group input:focus, .form-group select:focus {
      outline: none;
      border-color: #ff8c42;
      box-shadow: 0 0 0 3px rgba(255, 140, 66, 0.1);
    }

    .form-group small {
      display: block;
      color: #8ba0b5;
      font-size: 0.7rem;
      margin-top: 6px;
    }

    .button-group {
      display: flex;
      gap: 12px;
      margin-top: 32px;
      flex-wrap: wrap;
    }

    .btn {
      padding: 12px 24px;
      border-radius: 40px;
      font-weight: 600;
      font-size: 0.9rem;
      cursor: pointer;
      border: none;
      transition: 0.2s;
      font-family: 'Inter', sans-serif;
    }

    .btn-primary {
      background: #ff8c42;
      color: white;
    }

    .btn-primary:hover {
      background: #e67328;
      transform: translateY(-1px);
    }

    .btn-secondary {
      background: #eef2f8;
      color: #4a627a;
    }

    .btn-secondary:hover {
      background: #e2e8f0;
    }

    .btn-outline {
      background: transparent;
      border: 1.5px solid #ff8c42;
      color: #ff8c42;
    }

    .btn-outline:hover {
      background: #fff5ec;
    }

    .alert {
      padding: 14px 18px;
      border-radius: 16px;
      margin-bottom: 24px;
      display: none;
    }

    .alert-success {
      background: #d9f0e1;
      color: #1f7840;
      border-left: 4px solid #2ecc71;
      display: block;
    }

    .alert-error {
      background: #ffe6e5;
      color: #c0392b;
      border-left: 4px solid #e74c3c;
      display: block;
    }

    /* Trip List View (Dashboard setelah create) */
    .trips-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 24px;
      margin-top: 24px;
    }

    .trip-card {
      background: white;
      border-radius: 24px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      transition: 0.2s;
      border: 1px solid #eef2f8;
    }

    .trip-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 24px rgba(0,0,0,0.1);
    }

    .trip-card h3 {
      font-size: 1.2rem;
      margin-bottom: 12px;
      color: #1f4e6e;
    }

    .trip-detail-item {
      font-size: 0.85rem;
      color: #6c86a0;
      margin-bottom: 8px;
      display: flex;
      gap: 8px;
    }

    .trip-detail-item i {
      width: 20px;
      color: #ff8c42;
    }

    .badge {
      background: #eef2ff;
      padding: 4px 12px;
      border-radius: 30px;
      font-size: 0.7rem;
      font-weight: 600;
      display: inline-block;
      margin-top: 10px;
    }

    .empty-state {
      text-align: center;
      padding: 60px 20px;
      color: #8ba0b5;
    }

    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
      flex-wrap: wrap;
      gap: 16px;
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 240px;
      }
      .main-content {
        margin-left: 240px;
        padding: 20px;
      }
      .form-card {
        padding: 24px;
      }
    }

    @media (max-width: 640px) {
      .sidebar {
        display: none;
      }
      .main-content {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>
<div class="app-container">
  <!-- SIDEBAR -->
  <div class="sidebar">
    <div class="logo">
      <i class="fas fa-map-marked-alt"></i>
      <span>planTravel</span>
    </div>
    <div class="nav-section">
      <h4>DASHBOARD</h4>
      <ul class="nav-items">
        <li id="navDashboard"><i class="fas fa-home"></i> Dashboard</li>
        <li id="navDestinasi"><i class="fas fa-location-dot"></i> Destinasi</li>
        <li id="navBudget"><i class="fas fa-chart-line"></i> Estimasi Budget Trip</li>
        <li id="navJadwal"><i class="fas fa-calendar-week"></i> Jadwal Perjalanan</li>
        <li id="navPacking"><i class="fas fa-suitcase"></i> Daftar Packing List</li>
        <li id="navRencanaTrip"><i class="fas fa-trip"></i> Rencana Trip</li>
      </ul>
    </div>
    <div class="nav-section">
      <h4>ADMINISTRATION</h4>
      <ul class="nav-items">
        <li><i class="fas fa-users"></i> Users</li>
        <li><i class="fas fa-user-tag"></i> Roles</li>
        <li><i class="fas fa-history"></i> Activity Log</li>
      </ul>
    </div>
  </div>

  <!-- MAIN CONTENT -->
  <div class="main-content">
    <div class="breadcrumb">
      <span>Rencana Trip</span> <i class="fas fa-chevron-right" style="font-size:10px;"></i>
      <span style="color:#ff8c42;">Create</span>
    </div>

    <!-- Container untuk konten dinamis (Create Trip atau Dashboard) -->
    <div id="appView">
      <!-- Form Create Trip akan di-render di sini -->
    </div>
  </div>
</div>

<script>
  // ========== DATA STORAGE (Simulasi Database) ==========
  // Data trip disimpan di localStorage agar persisten
  let trips = [];

  // Load data dari localStorage saat pertama kali
  function loadTripsFromStorage() {
    const stored = localStorage.getItem('planTravel_trips');
    if (stored) {
      trips = JSON.parse(stored);
    } else {
      // Data dummy awal (contoh)
      trips = [
        {
          id: 1,
          name: "Eksplorasi Jepang Bersama Keluarga",
          destination: "Tokyo, Jepang",
          startDate: "2027-06-15",
          participants: 4,
          createdAt: new Date().toISOString()
        },
        {
          id: 2,
          name: "Liburan ke Bali",
          destination: "Bali, Indonesia",
          startDate: "2026-12-10",
          participants: 2,
          createdAt: new Date().toISOString()
        }
      ];
      saveTripsToStorage();
    }
  }

  function saveTripsToStorage() {
    localStorage.setItem('planTravel_trips', JSON.stringify(trips));
  }

  // Helper format tanggal
  function formatDate(dateStr) {
    if (!dateStr) return '-';
    const d = new Date(dateStr);
    return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
  }

  // ========== RENDER DASHBOARD (List semua trip) ==========
  function renderDashboard() {
    const appView = document.getElementById('appView');
    
    if (trips.length === 0) {
      appView.innerHTML = `
        <div class="page-header">
          <h2 style="color:#1e3a4d;">✈️ Rencana Trip Saya</h2>
          <button class="btn btn-primary" id="createNewTripBtn"><i class="fas fa-plus"></i> Buat Trip Baru</button>
        </div>
        <div class="empty-state">
          <i class="fas fa-map-marked-alt" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
          <p>Belum ada rencana trip. Yuk buat trip pertamamu!</p>
          <button class="btn btn-primary" style="margin-top: 20px;" id="emptyCreateBtn">+ Buat Trip Baru</button>
        </div>
      `;
    } else {
      let tripsHtml = `
        <div class="page-header">
          <h2 style="color:#1e3a4d;">✈️ Rencana Trip Saya</h2>
          <button class="btn btn-primary" id="createNewTripBtn"><i class="fas fa-plus"></i> Buat Trip Baru</button>
        </div>
        <div class="trips-grid">
      `;
      trips.forEach(trip => {
        tripsHtml += `
          <div class="trip-card">
            <h3><i class="fas fa-flag-checkered" style="color:#ff8c42;"></i> ${escapeHtml(trip.name)}</h3>
            <div class="trip-detail-item"><i class="fas fa-city"></i> ${escapeHtml(trip.destination)}</div>
            <div class="trip-detail-item"><i class="fas fa-calendar-alt"></i> Berangkat: ${formatDate(trip.startDate)}</div>
            <div class="trip-detail-item"><i class="fas fa-user-friends"></i> ${trip.participants} Peserta</div>
            <div class="badge"><i class="far fa-clock"></i> Dibuat: ${formatDate(trip.createdAt)}</div>
            <div style="margin-top: 14px; display: flex; gap: 10px;">
              <button class="btn-outline" style="padding: 6px 12px; font-size:0.75rem;" onclick="editTrip(${trip.id})"><i class="fas fa-edit"></i> Edit</button>
              <button class="btn-outline" style="padding: 6px 12px; font-size:0.75rem; border-color:#e74c3c; color:#e74c3c;" onclick="deleteTrip(${trip.id})"><i class="fas fa-trash"></i> Hapus</button>
            </div>
          </div>
        `;
      });
      tripsHtml += `</div>`;
      appView.innerHTML = tripsHtml;
    }

    // Event listener untuk tombol buat trip
    document.getElementById('createNewTripBtn')?.addEventListener('click', showCreateTripForm);
    document.getElementById('emptyCreateBtn')?.addEventListener('click', showCreateTripForm);
  }

  // Hapus trip
  window.deleteTrip = function(tripId) {
    if (confirm('Yakin ingin menghapus rencana trip ini?')) {
      trips = trips.filter(t => t.id !== tripId);
      saveTripsToStorage();
      renderDashboard();
      showToast('Trip berhasil dihapus', 'success');
    }
  };

  // Edit trip (sederhana: isi form lagi)
  window.editTrip = function(tripId) {
    const trip = trips.find(t => t.id === tripId);
    if (trip) {
      showCreateTripForm(trip);
    }
  };

  // Toast sederhana
  function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.style.position = 'fixed';
    toast.style.bottom = '20px';
    toast.style.right = '20px';
    toast.style.background = type === 'success' ? '#2ecc71' : '#e74c3c';
    toast.style.color = 'white';
    toast.style.padding = '12px 20px';
    toast.style.borderRadius = '40px';
    toast.style.fontSize = '0.85rem';
    toast.style.zIndex = '9999';
    toast.style.boxShadow = '0 4px 12px rgba(0,0,0,0.2)';
    toast.innerText = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2500);
  }

  // ========== FORM CREATE / EDIT TRIP ==========
  function showCreateTripForm(editData = null) {
    const appView = document.getElementById('appView');
    const isEdit = !!editData;
    
    appView.innerHTML = `
      <div class="form-card">
        <div class="form-title">${isEdit ? 'Edit' : 'Create'} Trip</div>
        <div class="form-subtitle">Silakan isi informasi lengkap rencana perjalanan.</div>
        
        <div id="formAlert" class="alert"></div>
        
        <form id="tripForm">
          <div class="form-group">
            <label>Nama Rencana Trip <span class="required">*</span></label>
            <input type="text" id="tripName" placeholder="Contoh: Eksplorasi Jepang Bersama Keluarga" value="${isEdit ? escapeHtml(editData.name) : ''}" required>
            <small>Beri nama perjalanan Anda yang mudah diingat.</small>
          </div>
          
          <div class="form-group">
            <label>Kota / Negara Tujuan <span class="required">*</span></label>
            <input type="text" id="tripDestination" placeholder="Contoh: Tokyo, Jepang" value="${isEdit ? escapeHtml(editData.destination) : ''}" required>
          </div>
          
          <div class="form-group">
            <label>Tanggal Keberangkatan <span class="required">*</span></label>
            <input type="date" id="tripDate" value="${isEdit ? editData.startDate : ''}" required>
          </div>
          
          <div class="form-group">
            <label>Jumlah Peserta <span class="required">*</span></label>
            <input type="number" id="tripParticipants" min="1" value="${isEdit ? editData.participants : '1'}" required>
          </div>
          
          <div class="button-group">
            <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
            <button type="button" class="btn btn-outline" id="createAnotherBtn">${isEdit ? 'Update & tetap di form' : 'Create & create another'}</button>
            <button type="submit" class="btn btn-primary" id="submitBtn">${isEdit ? 'Update' : 'Create'}</button>
          </div>
        </form>
      </div>
    `;

    // Event handlers
    document.getElementById('cancelBtn').addEventListener('click', () => {
      renderDashboard();
    });

    const form = document.getElementById('tripForm');
    const createAnotherBtn = document.getElementById('createAnotherBtn');
    
    // Fungsi utama simpan
    const saveTrip = (stayInForm = false) => {
      const name = document.getElementById('tripName').value.trim();
      const destination = document.getElementById('tripDestination').value.trim();
      const startDate = document.getElementById('tripDate').value;
      const participants = parseInt(document.getElementById('tripParticipants').value);

      if (!name || !destination || !startDate || !participants) {
        showFormAlert('Semua field harus diisi!', 'error');
        return false;
      }

      if (isEdit) {
        // Update existing trip
        const index = trips.findIndex(t => t.id === editData.id);
        if (index !== -1) {
          trips[index] = {
            ...trips[index],
            name: name,
            destination: destination,
            startDate: startDate,
            participants: participants
          };
          saveTripsToStorage();
          showToast('Trip berhasil diperbarui!', 'success');
        }
      } else {
        // Create new trip
        const newId = trips.length > 0 ? Math.max(...trips.map(t => t.id)) + 1 : 1;
        const newTrip = {
          id: newId,
          name: name,
          destination: destination,
          startDate: startDate,
          participants: participants,
          createdAt: new Date().toISOString()
        };
        trips.push(newTrip);
        saveTripsToStorage();
        showToast('Trip baru berhasil dibuat!', 'success');
      }

      if (stayInForm) {
        // Reset form untuk create another (hanya jika bukan edit)
        if (!isEdit) {
          document.getElementById('tripName').value = '';
          document.getElementById('tripDestination').value = '';
          document.getElementById('tripDate').value = '';
          document.getElementById('tripParticipants').value = '1';
          showFormAlert('Trip tersimpan! Silakan buat trip lagi.', 'success');
        } else {
          // Jika edit, stay di form tapi tidak reset
          showFormAlert('Perubahan tersimpan!', 'success');
        }
      } else {
        // Kembali ke dashboard
        renderDashboard();
      }
      return true;
    };

    // Submit utama
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      saveTrip(false);
    });

    // Create & create another
    createAnotherBtn.addEventListener('click', () => {
      if (isEdit) {
        // Edit mode: simpan tapi tetap di form
        saveTrip(true);
      } else {
        saveTrip(true);
      }
    });

    function showFormAlert(msg, type) {
      const alertDiv = document.getElementById('formAlert');
      alertDiv.innerText = msg;
      alertDiv.className = `alert alert-${type === 'error' ? 'error' : 'success'}`;
      setTimeout(() => {
        alertDiv.style.display = 'none';
        alertDiv.className = 'alert';
      }, 3000);
    }
  }

  function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
      if (m === '&') return '&amp;';
      if (m === '<') return '&lt;';
      if (m === '>') return '&gt;';
      return m;
    });
  }

  // ========== NAVIGASI SEDERHANA (untuk menu lain) ==========
  function setupNavigation() {
    document.getElementById('navDashboard')?.addEventListener('click', renderDashboard);
    document.getElementById('navRencanaTrip')?.addEventListener('click', renderDashboard);
    document.getElementById('navDestinasi')?.addEventListener('click', () => {
      document.getElementById('appView').innerHTML = `<div class="form-card"><h3>📌 Halaman Destinasi</h3><p>Fitur destinasi akan terhubung dengan trip yang sudah dibuat.</p><button class="btn btn-primary" onclick="renderDashboard()">Kembali ke Trip</button></div>`;
    });
    document.getElementById('navBudget')?.addEventListener('click', () => {
      document.getElementById('appView').innerHTML = `<div class="form-card"><h3>💰 Estimasi Budget Trip</h3><p>Fitur anggaran perjalanan berdasarkan trip terpilih.</p><button class="btn btn-primary" onclick="renderDashboard()">Kembali</button></div>`;
    });
    document.getElementById('navJadwal')?.addEventListener('click', () => {
      document.getElementById('appView').innerHTML = `<div class="form-card"><h3>📅 Jadwal Perjalanan (Itinerary)</h3><p>Buat itinerary untuk setiap trip.</p><button class="btn btn-primary" onclick="renderDashboard()">Kembali</button></div>`;
    });
    document.getElementById('navPacking')?.addEventListener('click', () => {
      document.getElementById('appView').innerHTML = `<div class="form-card"><h3>🎒 Daftar Packing List</h3><p>Kelola packing list berdasarkan trip.</p><button class="btn btn-primary" onclick="renderDashboard()">Kembali</button></div>`;
    });
  }

  // Inisialisasi
  loadTripsFromStorage();
  renderDashboard();
  setupNavigation();
</script>
</body>
</html>