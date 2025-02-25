import { Routes } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { EmployeeComponent } from './employee/employee.component';


export const routes: Routes = [
    { path: '', redirectTo: 'login', pathMatch: 'full' }, // Redirect empty path to 'login'
    { path: 'login', component: LoginComponent },           // Define 'login' path and component
    { path: 'dashboard', component: DashboardComponent,
        children: [
            { path: 'employee', component: EmployeeComponent },
            
        ]
     },    // Define 'dashboard' path
];