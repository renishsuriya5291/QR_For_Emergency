import { Component } from '@angular/core';
import { RegisterForm } from '../../../types/Auth';
import { AuthService } from '../auth.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css'],
})
export class RegisterComponent {
  form: RegisterForm = {
    confirm_password: '',
    email: '',
    password: '',
  };

  // Add a property to track password visibility
  passwordVisible: boolean = false;

  constructor(private authService: AuthService) {}

  submit() {
    this.authService.register(this.form);
  }

  isLoading() {
    return this.authService.isLoading;
  }

  signUpWithGoogle(event: Event) {
    console.log('signUpWithGoogle');
    event.preventDefault();
  }

  signUpWithFacebook(event: Event) {
    event.preventDefault();
  }

  // Method to toggle password visibility
  togglePasswordVisibility() {
    this.passwordVisible = !this.passwordVisible;
  }
}
