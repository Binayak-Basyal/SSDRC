import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { EmployeeService } from './employee.service';
import { Employee } from './employee.model';

@Component({
    selector: 'app-employee',
    standalone: true,
    imports: [CommonModule, FormsModule, ReactiveFormsModule],
    templateUrl: './employee.component.html',
    styleUrls: ['./employee.component.css']
})
export class EmployeeComponent implements OnInit {
    employees: Employee[] = [];
    isModalVisible: boolean = false;
    employeeForm: FormGroup;
    editingEmployee: Employee | null = null;
    errorMessage: string | null = null;

    constructor(
        private employeeService: EmployeeService,
        private fb: FormBuilder
    ) {
        this.employeeForm = this.fb.group({
            first_name: ['', Validators.required],
            last_name: ['', Validators.required],
            email: ['', [Validators.required, Validators.email]],
            phone: [''],
            address: [''],
            post: ['', Validators.required],
            salary: [null],
            status: ['active', Validators.required]
        });
    }

    ngOnInit(): void {
        this.loadEmployees();
    }

    loadEmployees(): void {
        this.employeeService.getEmployees().subscribe({
            next: (data) => {
                this.employees = data;
                this.errorMessage = null;
            },
            error: (error) => {
                console.error('Error loading employees:', error);
                this.employees = [];
                this.errorMessage = 'Failed to load employees.';
            }
        });
    }

    openAddModal(): void {
        this.editingEmployee = null;
        this.employeeForm.reset();
        this.isModalVisible = true;
    }

    openEditModal(employee: Employee): void {
        this.editingEmployee = employee;
        this.employeeForm.patchValue(employee);
        this.isModalVisible = true;
    }

    closeModal(): void {
        this.isModalVisible = false;
        this.editingEmployee = null;
        this.employeeForm.reset();
    }

    onSubmit(): void {
      debugger;
        if (this.employeeForm.valid) {
            const employeeData = this.employeeForm.value;
            if (this.editingEmployee) {
                this.employeeService.updateEmployee(this.editingEmployee.id!, employeeData).subscribe({
                    next: () => {
                        this.closeModal();
                        this.loadEmployees();
                    },
                    error: (error) => {
                        console.error('Error updating employee:', error);
                        this.errorMessage = 'Error updating employee. Please check console.';
                    }
                });
            } else {
                this.employeeService.addEmployee(employeeData).subscribe({
                    next: () => {
                        this.closeModal();
                        this.loadEmployees();
                    },
                    error: (error: any) => {
                        console.error('Error adding employee:', error);
                        this.errorMessage = 'Error adding employee. Please check console.';
                    }
                });
            }
        }
    }

    deleteEmployee(id: number): void {
        if (confirm('Are you sure you want to delete this employee?')) {
            this.employeeService.deleteEmployee(id).subscribe({
                next: () => {
                    this.loadEmployees();
                },
                error: (error) => {
                    console.error('Error deleting employee:', error);
                    this.errorMessage = 'Error deleting employee. Please check console.';
                }
            });
        }
    }
}