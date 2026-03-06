class CreateFacebookPagesTable extends Migration {
    public function up() {
        Schema::create('facebook_pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_id')->unique();
            $table->string('name');
            $table->string('access_token');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('facebook_pages');
    }
}