import "./bootstrap";
import "./template/index";

// ✅ jQuery 3.x (GLOBAL)
import $ from "jquery";
window.$ = window.jQuery = $;

console.log("jQuery version:", $.fn.jquery);

// DataTables
import "datatables.net";
import "datatables.net-dt/css/dataTables.dataTables.css";

import "datatables.net-responsive";
import "datatables.net-responsive-dt/css/responsive.dataTables.css";

// Alpine TERAKHIR
import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

// SweetAlert2
import Swal from "sweetalert2";
window.Swal = Swal;
