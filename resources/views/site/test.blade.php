<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Organizasyon Şeması</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/jsplumb@2.15.6/dist/js/jsplumb.min.js"></script>
  <style>
    body {
      background-color: #f8f9fa;
      padding: 40px;
    }
    .org-container {
      position: relative;
      height: 800px;
    }
    .org-card {
      width: 180px;
      padding: 15px;
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }
    .org-card img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 10px;
    }
    .absolute {
      position: absolute;
    }
  </style>
</head>
<body>

<div class="container">
  <h3 class="mb-4 text-center">Organizasyon Şeması</h3>

  <div class="org-container" id="org-chart">

    <!-- Müdür -->
    <div class="org-card absolute" id="node1" style="top: 20px; left: 50%; transform: translateX(-50%);">
      <img src="https://randomuser.me/api/portraits/men/10.jpg">
      <h6 class="mb-0">Ahmet Yılmaz</h6>
      <small class="text-muted">Müdür</small>
    </div>

    <!-- Müdür Yardımcısı -->
    <div class="org-card absolute" id="node2" style="top: 180px; left: 50%; transform: translateX(-50%);">
      <img src="https://randomuser.me/api/portraits/men/20.jpg">
      <h6 class="mb-0">Mehmet Demir</h6>
      <small class="text-muted">Müdür Yardımcısı</small>
    </div>

    <!-- Müdürlükler -->
    <div class="org-card absolute" id="node3" style="top: 360px; left: 10%;">
      <img src="https://randomuser.me/api/portraits/women/30.jpg">
      <h6 class="mb-0">Ayşe Kaya</h6>
      <small class="text-muted">İK Müdürü</small>
    </div>

    <div class="org-card absolute" id="node4" style="top: 360px; left: 28%;">
      <img src="https://randomuser.me/api/portraits/women/40.jpg">
      <h6 class="mb-0">Fatma Şahin</h6>
      <small class="text-muted">Finans Müdürü</small>
    </div>

    <div class="org-card absolute" id="node5" style="top: 360px; left: 46%;">
      <img src="https://randomuser.me/api/portraits/men/50.jpg">
      <h6 class="mb-0">Ali Çelik</h6>
      <small class="text-muted">Pazarlama Müdürü</small>
    </div>

    <div class="org-card absolute" id="node6" style="top: 360px; left: 64%;">
      <img src="https://randomuser.me/api/portraits/women/60.jpg">
      <h6 class="mb-0">Zeynep Yıldız</h6>
      <small class="text-muted">Satış Müdürü</small>
    </div>

    <div class="org-card absolute" id="node7" style="top: 360px; left: 82%;">
      <img src="https://randomuser.me/api/portraits/men/70.jpg">
      <h6 class="mb-0">Murat Erdem</h6>
      <small class="text-muted">IT Müdürü</small>
    </div>

  </div>
</div>

<script>
  jsPlumb.ready(function () {
    const instance = jsPlumb.getInstance({
      Connector: "Straight",
      PaintStyle: { stroke: "#000", strokeWidth: 2 },
      Endpoint: "Blank",
      Anchors: ["Bottom", "Top"],
      Container: "org-chart"
    });

    // Bağlantılar
    instance.connect({ source: "node1", target: "node2" });

    for (let i = 3; i <= 7; i++) {
      instance.connect({ source: "node2", target: "node" + i });
    }
  });
</script>

</body>
</html>
