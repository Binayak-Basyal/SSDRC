import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http'; // Import HttpHeaders
import { Observable } from 'rxjs';
import { Employee } from './employee.model';

@Injectable({
    providedIn: 'root'
})
export class EmployeeService {
    private apiUrl = 'http://localhost:8000/api/admin/employees';

    constructor(private http: HttpClient) { }

    private getRequestOptions() { // Helper function to set withCredentials
        return {
            withCredentials: true,
            headers: new HttpHeaders({
                'Content-Type': 'application/json' // Or your content type if needed
            })
        };
    }

    getEmployees(): Observable<Employee[]> {
        return this.http.get<Employee[]>(this.apiUrl, this.getRequestOptions()); // Apply options
    }

    addEmployee(employeeData: Employee): Observable<Employee> {
        return this.http.post<Employee>(this.apiUrl, employeeData, this.getRequestOptions()); // Apply options
    }

    updateEmployee(id: number, employeeData: Employee): Observable<Employee> {
        return this.http.put<Employee>(`${this.apiUrl}/${id}`, employeeData, this.getRequestOptions()); // Apply options
    }

    deleteEmployee(id: number): Observable<void> {
        return this.http.delete<void>(`${this.apiUrl}/${id}`, this.getRequestOptions()); // Apply options
    }

    getEmployeeById(id: number): Observable<Employee> {
        return this.http.get<Employee>(`${this.apiUrl}/${id}`, this.getRequestOptions()); // Apply options
    }
}