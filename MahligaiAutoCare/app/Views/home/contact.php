<div class="container-fluid contact py-5" style="background-color: #f8f9fa;"> <div class="container py-5">
        <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary border-bottom pb-4 mb-4">Hubungi Kami</h4>
            <h1 class="display-3 mb-5">Jangan Ragu untuk Menghubungi Kami</h1>
            <p class="mb-0">
                Kami siap membantu Anda dengan pertanyaan, saran, atau keluhan. Isi formulir di bawah atau hubungi kami langsung.
            </p>
        </div>
        <div class="row g-5 justify-content-center"> <div class="col-xl-6 wow fadeIn" data-wow-delay="0.3s">
               <div class="contact-detail-map h-100 rounded shadow-lg overflow-hidden">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.65868612161!2d101.46497787496472!3d0.522222199616856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5ac1a27315575%3A0x296fdc7322314a5b!2sMahligai%20Autocare!5e0!3m2!1sen!2sid!4v1720158863266!5m2!1sen!2sid"
                        class="w-100 h-100" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div class="col-xl-6 wow fadeIn" data-wow-delay="0.5s">
                <div class="p-5 bg-light rounded shadow-lg h-100"> <?php if (isset($message) && !empty($message)): ?>
                        <div class="alert alert-<?= htmlspecialchars($message_type) ?> alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($message) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <form action="<?= htmlspecialchars($base_url) ?>/contact" method="POST">
                        <div class="row g-4">
                            <div class="col-12">
                                <label for="name" class="form-label">Nama Anda</label>
                                <input type="text" id="name" class="form-control p-3 border-0 bg-white" name="name" placeholder="Nama Lengkap" value="<?= htmlspecialchars($input_name ?? '') ?>" required>
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label">Email Anda</label>
                                <input type="email" id="email" class="form-control p-3 border-0 bg-white" name="email" placeholder="email@example.com" value="<?= htmlspecialchars($input_email ?? '') ?>" required>
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label">Subjek</label>
                                <input type="text" id="subject" class="form-control p-3 border-0 bg-white" name="subject" placeholder="Subjek Pesan" required>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Pesan Anda</label>
                                <textarea class="w-100 form-control p-3 border-0 bg-white" id="message" name="message" rows="6" placeholder="Tuliskan pesan Anda di sini" required></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary border-0 w-100 py-3 rounded-pill" type="submit">Kirim Pesan</button> </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>