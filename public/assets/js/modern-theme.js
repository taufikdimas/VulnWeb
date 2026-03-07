// Modern Theme JavaScript
document.addEventListener("DOMContentLoaded", function () {
  // ==================== SIDEBAR TOGGLE ====================
  const sidebarToggle = document.getElementById("sidebarToggle");
  const sidebar = document.getElementById("sidebar");
  const content = document.getElementById("content");

  // Load sidebar state from localStorage
  const sidebarCollapsed = localStorage.getItem("sidebarCollapsed") === "true";
  if (sidebarCollapsed && sidebar) {
    sidebar.classList.add("collapsed");
  }

  // Toggle sidebar on button click
  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener("click", function (e) {
      e.preventDefault();
      sidebar.classList.toggle("collapsed");

      // Save state to localStorage
      const isCollapsed = sidebar.classList.contains("collapsed");
      localStorage.setItem("sidebarCollapsed", isCollapsed);
    });
  }

  // ==================== MOBILE SIDEBAR ====================
  // On mobile, show/hide sidebar instead of collapse
  if (window.innerWidth <= 768 && sidebarToggle && sidebar) {
    sidebarToggle.addEventListener("click", function (e) {
      e.preventDefault();
      sidebar.classList.toggle("show");
    });

    // Close sidebar when clicking outside
    document.addEventListener("click", function (e) {
      if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
        sidebar.classList.remove("show");
      }
    });
  }

  // ==================== AUTO-HIDE ALERTS ====================
  const alerts = document.querySelectorAll(".alert");
  alerts.forEach((alert) => {
    // Add close button if not present
    if (!alert.querySelector(".btn-close")) {
      const closeBtn = document.createElement("button");
      closeBtn.type = "button";
      closeBtn.className = "btn-close";
      closeBtn.setAttribute("data-bs-dismiss", "alert");
      closeBtn.setAttribute("aria-label", "Close");
      alert.appendChild(closeBtn);
    }

    // Auto-hide after 5 seconds
    setTimeout(() => {
      alert.style.transition = "opacity 0.5s, transform 0.5s";
      alert.style.opacity = "0";
      alert.style.transform = "translateY(-20px)";
      setTimeout(() => alert.remove(), 500);
    }, 5000);
  });

  // ==================== FORM VALIDATION ====================
  const forms = document.querySelectorAll("form[data-validate]");
  forms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      const requiredFields = form.querySelectorAll("[required]");
      let isValid = true;

      requiredFields.forEach((field) => {
        if (!field.value.trim()) {
          isValid = false;
          field.classList.add("is-invalid");

          // Add error message if not present
          if (
            !field.nextElementSibling ||
            !field.nextElementSibling.classList.contains("invalid-feedback")
          ) {
            const errorDiv = document.createElement("div");
            errorDiv.className = "invalid-feedback";
            errorDiv.textContent = "This field is required";
            field.parentNode.insertBefore(errorDiv, field.nextSibling);
          }
        } else {
          field.classList.remove("is-invalid");

          // Remove error message
          if (
            field.nextElementSibling &&
            field.nextElementSibling.classList.contains("invalid-feedback")
          ) {
            field.nextElementSibling.remove();
          }
        }
      });

      if (!isValid) {
        e.preventDefault();
      }
    });

    // Remove validation errors on input
    const inputs = form.querySelectorAll("input, textarea, select");
    inputs.forEach((input) => {
      input.addEventListener("input", function () {
        if (this.classList.contains("is-invalid")) {
          this.classList.remove("is-invalid");
          if (
            this.nextElementSibling &&
            this.nextElementSibling.classList.contains("invalid-feedback")
          ) {
            this.nextElementSibling.remove();
          }
        }
      });
    });
  });

  // ==================== SMOOTH ANIMATIONS ====================
  // Add fade-in animation to cards
  const cards = document.querySelectorAll(".card, .stats-card");
  cards.forEach((card, index) => {
    card.style.opacity = "0";
    card.style.transform = "translateY(20px)";

    setTimeout(() => {
      card.style.transition = "opacity 0.5s ease, transform 0.5s ease";
      card.style.opacity = "1";
      card.style.transform = "translateY(0)";
    }, index * 100);
  });

  // ==================== TOOLTIPS ====================
  // Initialize Bootstrap tooltips if available
  if (typeof bootstrap !== "undefined" && bootstrap.Tooltip) {
    const tooltipTriggerList = [].slice.call(
      document.querySelectorAll('[data-bs-toggle="tooltip"]'),
    );
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  }

  // ==================== CONFIRMATION DIALOGS ====================
  const deleteButtons = document.querySelectorAll("[data-confirm]");
  deleteButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      const message = this.getAttribute("data-confirm") || "Are you sure?";
      if (!confirm(message)) {
        e.preventDefault();
        return false;
      }
    });
  });

  // ==================== TABLE SEARCH ====================
  const tableSearch = document.getElementById("tableSearch");
  if (tableSearch) {
    tableSearch.addEventListener("keyup", function () {
      const searchValue = this.value.toLowerCase();
      const table = document.querySelector("table tbody");
      const rows = table.getElementsByTagName("tr");

      Array.from(rows).forEach((row) => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? "" : "none";
      });
    });
  }

  // ==================== RESPONSIVE HANDLING ====================
  window.addEventListener("resize", function () {
    if (window.innerWidth > 768 && sidebar) {
      sidebar.classList.remove("show");
    }
  });
});
