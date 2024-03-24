import { Injectable } from '@angular/core';
import { LoginForm, RegisterForm } from '../../types/Auth';
import {
  createUserWithEmailAndPassword,
  getAuth,
  signInWithEmailAndPassword,
  signOut,
} from 'firebase/auth';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  isLoading: boolean = false;

  constructor() {}

  login(form: LoginForm) {
    if (this.isLoading) return;
    this.isLoading = true;
    const auth = getAuth();
    signInWithEmailAndPassword(auth, form.email, form.password)
      .then((userCredential) => {
        // alert('Login Success!' + userCredential);
        console.log('Login Success!');
        
      })
      .catch((error) => {
        const errorCode = error.code;
        const errorMessage = error.message;
        // alert('Credentials does not match our record.');
        console.log("Credentials does not match our record");
        
      }).finally(() => (this.isLoading = false));
  }

  register(form: RegisterForm) {
    if (this.isLoading) return;
    this.isLoading = true;
    const auth = getAuth();
    createUserWithEmailAndPassword(auth, form.email, form.password)
      .then((userCredential) => {
        // alert(userCredential);
        console.log(userCredential);
        
        // ...
      })
      .catch((error) => {
        const errorCode = error.code;
        const errorMessage = error.message;
        // ..
        // alert(errorMessage);
        console.log(errorMessage);
        
      }).finally(() => (this.isLoading = false));
  }

  logout() {
    const auth = getAuth();
    signOut(auth)
      .then(() => {
        alert('Logout Success!');
      })
      .catch((error) => {
        alert('An error occurred while logging out.');
      });
  }
}
