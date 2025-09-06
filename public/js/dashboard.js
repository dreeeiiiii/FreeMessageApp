document.addEventListener("DOMContentLoaded", () => {
    // ===== Shorten message preview =====
    document.querySelectorAll(".message-preview").forEach(item => {
        const fullMessage = item.dataset.full;
        const limit = parseInt(item.dataset.limit) || 20;
        const words = fullMessage.split(" ");
        const shortMessage = words.slice(0, limit).join(" ") + (words.length > limit ? "..." : "");
        item.textContent = shortMessage;

        item.addEventListener("click", () => {
            item.textContent = item.textContent === fullMessage ? shortMessage : fullMessage;
        });
    });

    // ===== Modal elements =====
    const viewModal = document.getElementById("viewModal");
    const replyModal = document.getElementById("replyModal");
    const deleteModal = document.getElementById("deleteModal");
    const viewMessageText = document.getElementById("viewMessageText");
    const replyIdInput = document.getElementById("replyId");
    const replyForm = document.getElementById("replyForm");
    const confirmDeleteBtn = document.getElementById("confirmDelete");
    let deleteId = null;

    // ===== Open View Modal =====
    document.querySelectorAll(".view-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const message = btn.closest("tr").querySelector(".message-preview").dataset.full;
            viewMessageText.textContent = message;
            viewModal.style.display = "flex";
        });
    });

    // ===== Open Reply Modal =====
    document.querySelectorAll(".reply-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            replyIdInput.value = btn.dataset.id;
            replyModal.style.display = "flex";
        });
    });

    // ===== Open Delete Modal =====
    document.querySelectorAll(".delete-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            deleteId = btn.dataset.id;
            deleteModal.style.display = "flex";
        });
    });

    // ===== Close Modals =====
    document.querySelectorAll(".close-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            viewModal.style.display = "none";
            replyModal.style.display = "none";
            deleteModal.style.display = "none";
        });
    });

    // ===== Reply Form Submission =====
   replyForm.addEventListener("submit", e => {
    e.preventDefault();

    const replyId = replyIdInput.value;
    const replyMessage = document.getElementById("replyText").value;

    fetch("send_reply.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: `id=${encodeURIComponent(replyId)}&message=${encodeURIComponent(replyMessage)}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Show success/fail message from PHP
        replyModal.style.display = "none";
        replyForm.reset();
    })
    .catch(err => alert("Error: " + err));
});


    // ===== Confirm Deletion =====
    confirmDeleteBtn.addEventListener("click", () => {
        if (deleteId) {
            // Redirect to PHP delete script
            window.location.href = `../includes/delete.php?id=${deleteId}`;
        }
    });

    // ===== Close modal when clicking outside =====
    window.addEventListener("click", e => {
        if (e.target.classList.contains("modal")) {
            e.target.style.display = "none";
        }
    });
});
