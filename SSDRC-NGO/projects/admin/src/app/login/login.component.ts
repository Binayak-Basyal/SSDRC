// login.component.ts
import { Component } from '@angular/core';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { HttpClient } from '@angular/common/http'; 
import { Router } from '@angular/router'; 
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';



@Component({
  selector: 'app-login',
  standalone: true,
  imports: [ReactiveFormsModule, CommonModule],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {
  loginForm = new FormGroup({
    email: new FormControl('', [Validators.required, Validators.email]), 
    password: new FormControl('', [Validators.required, Validators.minLength(6)])
  });
  errorMessage: string = ''; 

  constructor(
    private http: HttpClient, 
    private router: Router    
  ) { }

  onSubmit() {
    if (this.loginForm.valid) {
      const loginData = this.loginForm.value;

      this.http.post<any>('http://localhost:8000/api/admin/login', loginData) 
        .subscribe({
          next: (response) => {
            console.log('Login successful', response);

            this.router.navigate(['/dashboard']); 
          },
          error: (error) => {
            console.error('Login failed', error);
            this.errorMessage = 'Invalid email or password.'; 
          }
        });
    } else {
      console.log('Form is invalid. Please check the errors.');
      this.errorMessage = '';
    }
  }

  get email() { return this.loginForm.get('email'); } 
  get password() { return this.loginForm.get('password'); }
}