# 1. Cài đặt các gói phát triển cần thiết
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# 2. Kích hoạt extension pdo_pgsql
# Lệnh docker-php-ext-install là cách chuẩn để cài extension trong image PHP chính thức
RUN docker-php-ext-install pgsql pdo_pgsql

# Nếu bạn có các lệnh cài đặt extension khác, hãy thêm chúng vào đây.
