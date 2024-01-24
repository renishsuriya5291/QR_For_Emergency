import { Routes } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { SignupComponent } from './auth/signup/signup.component';
import { SigninComponent } from './auth/signin/signin.component';

export const routes: Routes = [
    {
        path: "",
        component: HomeComponent,
        title: "Home"
    },
    {
        path: "signup",
        component: SignupComponent,
        title: "Signup"
    },
    {
        path: "signin",
        component: SigninComponent,
        title: "Signin"
    },
];
