<style>
    .form-section {
  padding: 60px 0;
  background-color: #f3f4f6;
}

.form-container {
  max-width: 420px;
  margin: auto;
  background: white;
  padding: 40px 30px;
  border-radius: 8px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
}

.form-title {
  font-size: 26px;
  font-weight: bold;
  margin-bottom: 25px;
  text-align: center;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  font-weight: 500;
  margin-bottom: 6px;
}

.form-group input {
  width: 100%;
  padding: 10px 14px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 15px;
}

.form-btn {
  width: 100%;
  background-color: #111;
  color: white;
  padding: 12px;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  font-size: 16px;
  cursor: pointer;
  transition: 0.3s;
}

.form-btn:hover {
  background-color: #333;
}

.form-footer {
  text-align: center;
  margin-top: 15px;
  font-size: 14px;
}

.form-footer a {
  color: #e53637;
  text-decoration: none;
}

.form-footer a:hover {
  text-decoration: underline;
}

</style>



<section class="form-section">
  <div class="form-container">
    <h2 class="form-title">Create an Account</h2>
    <form action="process_signup.php" method="POST">
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" required />
      </div>
      <div class="form-group">
        <label>Email address</label>
        <input type="email" name="email" required />
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required />
      </div>
      <div class="form-group">
        <label>Address</label>
        <input type="text" name="address" required />
      </div>
      <div class="form-group">
        <label>Phone</label>
        <input type="text" name="phone" required />
      </div>
      <button type="submit" class="form-btn">Sign Up</button>
      <p class="form-footer">
        Already have an account? <a href="login.php">Login</a>
      </p>
    </form>
  </div>
</section>
