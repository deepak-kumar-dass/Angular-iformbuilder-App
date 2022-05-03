import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import { ToastService, AngularToastifyModule } from 'angular-toastify';  

@Component({
  selector: 'app-contact-us',
  templateUrl: './contact-us.component.html',
  styleUrls: ['./contact-us.component.css']
})
export class ContactUsComponent implements OnInit {
  contactForm : FormGroup;
  records :any
  submitted = false;
  IsCalling: boolean = false;
  constructor(private router:Router,private fb:FormBuilder,private http:HttpClient,private toastService: ToastService) { }
  ngOnInit(): void {
    this.contactForm = this.fb.group({
      cf_name : ["", Validators.required],
      cf_email : ["",[Validators.required, Validators.email]],
      cf_phone : ["",[Validators.required, Validators.pattern("[0-9 ]{10}")]],
      cf_message : ["",Validators.required]
    })
    // Store records in a variable
    this.records = this.getRecords();
    console.log(this.registerFormControl)
  }

  // Insert form data
  submitForm(){
    this.submitted = true;
    if (this.contactForm.valid) {
      this.IsCalling = true;
      this.http.post('http://127.0.0.1:8080/api/create.php',this.contactForm.value).subscribe(()=>{
        this.contactForm.reset();
        this.toastService.success('Data saved successfylly!');
        this.records = this.getRecords();
        this.IsCalling = false;
        this.submitted = false;
      });
    }
  }
  // Get All records
   getRecords(){
    this.http.get('http://127.0.0.1:8080/api/display.php').subscribe((response)=>{
      this.records = response;
      console.warn('response',this.records);
    });
   }

  get registerFormControl() {
    return this.contactForm.controls;
  }
}
